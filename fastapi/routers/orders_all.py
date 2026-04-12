from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from database import get_db
import models

router = APIRouter()

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
            "detalles": [
                {
                    "producto_id": d.producto_id,
                    "cantidad": d.cantidad,
                    "subtotal": float(d.subtotal)
                } for d in o.detalles
            ]
        })
    return result
