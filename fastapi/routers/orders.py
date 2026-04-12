from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from database import get_db
import models
import schemas
from decimal import Decimal

router = APIRouter()

@router.post("/", response_model=dict)
def create_order(order: schemas.OrderCreate, db: Session = Depends(get_db)):
    if not order.productos:
        raise HTTPException(status_code=400, detail="Order must contain at least one product")
        
    total: Decimal = Decimal('0.0')
    detalles = []
    
    for item in order.productos:
        producto_db = db.query(models.Producto).filter(models.Producto.id == item.producto_id).first()
        if not producto_db:
            raise HTTPException(status_code=404, detail=f"Product ID {item.producto_id} not found")
            
        inventario = db.query(models.Inventario).filter(models.Inventario.producto_id == item.producto_id).first()
        if not inventario or inventario.stock_actual < item.cantidad:
            raise HTTPException(status_code=400, detail=f"Insufficient stock for product {producto_db.nombre}")
            
        subtotal = producto_db.precio * item.cantidad
        total += subtotal
        detalles.append({
            "producto_id": item.producto_id,
            "cantidad": item.cantidad,
            "precio_unitario": producto_db.precio,
            "subtotal": subtotal,
            "inventario_obj": inventario
        })
    
    db_orden = models.Orden(
        usuario_id=order.usuario_id,
        tipo_cliente=order.tipo_cliente,
        estado='Pendiente',
        total=total,
        direccion_envio=order.direccion_envio,
        notas=order.notas
    )
    db.add(db_orden)
    db.commit()
    db.refresh(db_orden)
    
    for det in detalles:
        db_detalle = models.OrdenDetalle(
            orden_id=db_orden.id,
            producto_id=det["producto_id"],
            cantidad=det["cantidad"],
            precio_unitario=det["precio_unitario"],
            subtotal=det["subtotal"]
        )
        db.add(db_detalle)
        det["inventario_obj"].stock_actual -= det["cantidad"]
        
    db.commit()
    
    return {"message": "Order created successfully", "order_id": db_orden.id, "total": total}

@router.get("/user/{user_id}")
def get_user_orders(user_id: int, db: Session = Depends(get_db)):
    orders = db.query(models.Orden).filter(models.Orden.usuario_id == user_id).all()
    result = []
    for o in orders:
        result.append({
            "id": o.id,
            "estado": o.estado,
            "total": o.total,
            "creado_en": o.creado_en,
            "detalles": [
                {
                    "producto_id": d.producto_id,
                    "cantidad": d.cantidad,
                    "subtotal": d.subtotal
                } for d in o.detalles
            ]
        })
    return result

@router.get("/all")
def get_all_orders(db: Session = Depends(get_db)):
    orders = db.query(models.Orden).all()
    result = []
    for o in orders:
        result.append({
            "id": o.id,
            "usuario_id": o.usuario_id,
            "estado": o.estado,
            "total": float(o.total),
            "tipo_cliente": o.tipo_cliente,
            "creado_en": o.creado_en.isoformat() if o.creado_en else None,
        })
    return result

@router.put("/{order_id}")
def update_order_status(order_id: int, data: dict, db: Session = Depends(get_db)):
    order = db.query(models.Orden).filter(models.Orden.id == order_id).first()
    if not order:
        raise HTTPException(status_code=404, detail="Order not found")
    if "estado" in data:
        order.estado = data["estado"]
    db.commit()
    return {"message": "Order updated"}
