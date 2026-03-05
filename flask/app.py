from flask import Flask, render_template, request, redirect, url_for

app = Flask(__name__)

# Configuración básica (Dummy para desarrollo UI)
app.secret_key = 'macuin_secret_dev_key'

# --- RUTAS DE AUTENTICACIÓN ---
@app.route('/')
@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        # Simular inicio de sesión exitoso
        return redirect(url_for('dashboard'))
    return render_template('login.html')

@app.route('/logout')
def logout():
    return redirect(url_for('login'))

# --- RUTAS DEL DASHBOARD (REPORTES) ---
@app.route('/dashboard')
def dashboard():
    return render_template('dashboard.html')

# --- RUTAS DE PEDIDOS GLOBALES ---
@app.route('/orders')
def orders():
    return render_template('orders.html')

# --- RUTAS DE INVENTARIO ---
@app.route('/inventory')
def inventory():
    return render_template('inventory.html')


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
