from flask import Flask, render_template, request, redirect, url_for, session, flash, jsonify
import requests
import os

app = Flask(__name__)
app.secret_key = 'macuin_secret_dev_key'
API_URL = os.getenv('API_URL', 'http://api:8000')


def api_get(path):
    try:
        r = requests.get(f"{API_URL}{path}", timeout=5)
        return r.json() if r.status_code == 200 else []
    except:
        return []


def api_post(path, json_data):
    try:
        r = requests.post(f"{API_URL}{path}", json=json_data, timeout=5)
        return r.json(), r.status_code
    except:
        return {}, 500


def api_put(path, json_data):
    try:
        r = requests.put(f"{API_URL}{path}", json=json_data, timeout=5)
        return r.json(), r.status_code
    except:
        return {}, 500


def api_delete(path):
    try:
        r = requests.delete(f"{API_URL}{path}", timeout=5)
        return r.json(), r.status_code
    except:
        return {}, 500


def require_login():
    return 'user' not in session


def is_admin():
    return session.get('user', {}).get('rol_id') == 1


def is_internal_staff():
    return session.get('user', {}).get('rol_id') == 3


@app.context_processor
def inject_user_roles():
    return {
        'is_admin': is_admin(),
        'is_internal_staff': is_internal_staff()
    }


# ─── AUTH ──────────────────────────────────────────────────────
@app.route('/')
@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        email = request.form.get('email')
        password = request.form.get('password')
        data, code = api_post('/api/auth/login', {"email": email, "password": password})
        if code == 200 and isinstance(data, dict):
            user = data.get('user')
            if not user:
                flash('Autenticación recibida, pero la respuesta no contiene datos de usuario.')
            elif user.get('rol_id') in [1, 3]:
                session['user'] = user
                session['token'] = data.get('access_token')
                flash('Inicio de sesión correcto. Redirigiendo al dashboard interno...')
                return redirect(url_for('dashboard'))
            else:
                flash(f'Inicio de sesión correcto, pero tu rol actual ({user.get("rol_id")}) no tiene acceso al portal interno.')
        elif code == 401:
            flash('Credenciales incorrectas. Verifica tu correo y contraseña.')
        elif code == 500:
            flash('Error de conexión con el servicio de autenticación. Intenta de nuevo más tarde.')
        else:
            flash(f'Error de autenticación ({code}). Por favor contacta con soporte.')
    return render_template('login.html')


@app.route('/logout')
def logout():
    session.clear()
    return redirect(url_for('login'))


# ─── DASHBOARD ─────────────────────────────────────────────────
@app.route('/dashboard')
def dashboard():
    if require_login():
        return redirect(url_for('login'))
    # Estadísticas reales desde la API
    orders = api_get('/api/orders/all') or []
    products = api_get('/api/products') or []
    users = api_get('/api/users/list') or []
    total_ventas = sum(float(o.get('total', 0)) for o in orders)
    total_pedidos = len(orders)
    clientes = len([u for u in users if u.get('rol_id') == 2])
    ticket = (total_ventas / total_pedidos) if total_pedidos > 0 else 0
    stats = {
        'ventas': total_ventas,
        'pedidos': total_pedidos,
        'clientes': clientes,
        'ticket': ticket,
        'ordenes_recientes': orders[-5:][::-1]
    }
    return render_template('dashboard.html', stats=stats, is_admin=is_admin(), is_internal_staff=is_internal_staff())


# ─── INVENTARIO (CRUD completo) ─────────────────────────────────
@app.route('/inventory')
def inventory():
    if require_login():
        return redirect(url_for('login'))
    result = api_get('/api/products')
    if isinstance(result, dict):
        products = result.get('products', [])
    else:
        products = result or []
    return render_template('inventory.html', products=products)


@app.route('/inventory/create', methods=['POST'])
def inventory_create():
    if require_login():
        return redirect(url_for('login'))
    data = {
        "sku": request.form.get('sku'),
        "nombre": request.form.get('nombre'),
        "categoria": request.form.get('categoria', 'General'),
        "marca": request.form.get('marca', ''),
        "precio": float(request.form.get('precio', 0)),
        "descripcion": request.form.get('descripcion', ''),
        "stock": int(request.form.get('stock', 0)),
        "stock_minimo": int(request.form.get('stock_minimo', 5)),
    }
    _, code = api_post('/api/products/', data)
    if code == 200:
        flash('Producto creado exitosamente.')
    else:
        flash('Error al crear el producto.')
    return redirect(url_for('inventory'))


@app.route('/inventory/update/<int:product_id>', methods=['POST'])
def inventory_update(product_id):
    if require_login():
        return redirect(url_for('login'))
    data = {
        "nombre": request.form.get('nombre'),
        "marca": request.form.get('marca', ''),
        "precio": float(request.form.get('precio', 0)),
        "descripcion": request.form.get('descripcion', ''),
        "stock": int(request.form.get('stock', 0)),
    }
    _, code = api_put(f'/api/products/{product_id}', data)
    if code == 200:
        flash('Producto actualizado exitosamente.')
    else:
        flash('Error al actualizar el producto.')
    return redirect(url_for('inventory'))


@app.route('/inventory/delete/<int:product_id>', methods=['POST'])
def inventory_delete(product_id):
    if require_login():
        return redirect(url_for('login'))
    _, code = api_delete(f'/api/products/{product_id}')
    if code == 200:
        flash('Producto eliminado.')
    else:
        flash('Error al eliminar el producto.')
    return redirect(url_for('inventory'))


# ─── ÓRDENES (STAFF) ───────────────────────────────────────────
@app.route('/orders')
def orders():
    if require_login():
        return redirect(url_for('login'))
    all_orders = api_get('/api/orders/all')
    return render_template('orders.html', orders=all_orders)


@app.route('/pedidos/detalle/<int:order_id>')
def pedido_detalle(order_id):
    if require_login():
        return jsonify({'error': 'No autorizado'}), 401
    all_orders = api_get('/api/orders/all')
    if not isinstance(all_orders, list):
        return jsonify({'error': 'No se pudo obtener el detalle'}), 500
    order = next((o for o in all_orders if o.get('id') == order_id), None)
    if not order:
        return jsonify({'error': 'Pedido no encontrado'}), 404
    response = {
        'cliente': order.get('cliente_nombre') or f"Usuario {order.get('usuario_id')}",
        'tipo': order.get('tipo_cliente') or 'Cliente',
        'estado': order.get('estado') or 'Pendiente',
        'total': float(order.get('total', 0.0)),
        'creado_en': order.get('creado_en'),
        'productos': [
            {
                'nombre': d.get('producto_nombre') or f"Producto #{d.get('producto_id')}",
                'cantidad': d.get('cantidad', 0),
                'precio': f"${float(d.get('precio_unitario', 0.0)):.2f}",
                'subtotal': f"${float(d.get('subtotal', 0.0)):.2f}"
            }
            for d in order.get('detalles', [])
        ]
    }
    return jsonify(response)


@app.route('/orders/update/<int:order_id>', methods=['POST'])
def update_order(order_id):
    if require_login():
        return redirect(url_for('login'))
    nuevo_estado = request.form.get('estado')
    api_put(f'/api/orders/{order_id}', {"estado": nuevo_estado})
    flash(f'Estado del pedido actualizado a "{nuevo_estado}".')
    return redirect(url_for('orders'))


# ─── USUARIOS INTERNOS (CRUD) ────────────────────────────────────
@app.route('/users')
def users():
    if require_login():
        return redirect(url_for('login'))
    all_users = api_get('/api/users/list')
    return render_template('users.html', users=all_users)


@app.route('/users/create', methods=['POST'])
def create_user():
    if require_login():
        return redirect(url_for('login'))
    data = {
        "nombre": request.form.get('nombre'),
        "apellidos": request.form.get('apellidos'),
        "email": request.form.get('email'),
        "password": request.form.get('password'),
        "telefono": request.form.get('telefono', ''),
        "rol_id": int(request.form.get('rol_id', 3)),
    }
    _, code = api_post('/api/users/internal', data)
    if code == 200:
        flash('Usuario creado exitosamente.')
    else:
        flash('Error al crear el usuario. Puede que el correo ya exista.')
    return redirect(url_for('users'))


# ─── REPORTES (DESCARGAS) ───────────────────────────────────────
@app.route('/reports/<string:formato>/<string:tipo>')
def download_report(formato, tipo):
    if require_login():
        return redirect(url_for('login'))
    try:
        r = requests.get(f"{API_URL}/api/reports/{formato}/{tipo}", stream=True, timeout=15)
        if r.status_code == 200:
            return (r.content, 200, {
                'Content-Disposition': f'attachment; filename="reporte_{tipo}.{formato}"',
                'Content-Type': r.headers.get('content-type', 'application/octet-stream')
            })
    except Exception as e:
        pass
    flash("Error al generar el reporte.")
    return redirect(url_for('dashboard'))


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
