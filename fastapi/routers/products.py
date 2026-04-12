from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from database import get_db
import models

router = APIRouter()

@router.get("/")
def get_products(skip: int = 0, limit: int = 100, search: str = None, categoria: str = None, precio_min: float = None, precio_max: float = None, db: Session = Depends(get_db)):
    query = db.query(models.Producto).filter(models.Producto.activo == True)
    
    if search:
        query = query.filter(models.Producto.nombre.ilike(f"%{search}%") | models.Producto.marca.ilike(f"%{search}%"))
    if categoria:
        query = query.join(models.Categoria).filter(models.Categoria.nombre.ilike(f"%{categoria}%"))
    if precio_min is not None:
        query = query.filter(models.Producto.precio >= precio_min)
    if precio_max is not None:
        query = query.filter(models.Producto.precio <= precio_max)
    
    total = query.count()
    products = query.offset(skip).limit(limit).all()
    result = []
    for p in products:
        inv = db.query(models.Inventario).filter(models.Inventario.producto_id == p.id).first()
        result.append({
            "id": p.id,
            "sku": p.sku,
            "nombre": p.nombre,
            "descripcion": p.descripcion,
            "marca": p.marca,
            "precio": float(p.precio),
            "categoria": p.categoria.nombre if p.categoria else "",
            "stock": inv.stock_actual if inv else 0,
        })
    return {"total": total, "products": result}

@router.get("/{product_id}")
def get_product(product_id: int, db: Session = Depends(get_db)):
    p = db.query(models.Producto).filter(models.Producto.id == product_id).first()
    if not p:
        raise HTTPException(status_code=404, detail="Product not found")
    inv = db.query(models.Inventario).filter(models.Inventario.producto_id == p.id).first()
    return {
        "id": p.id,
        "sku": p.sku,
        "nombre": p.nombre,
        "descripcion": p.descripcion,
        "marca": p.marca,
        "precio": float(p.precio),
        "categoria": p.categoria.nombre if p.categoria else "",
        "stock": inv.stock_actual if inv else 0,
    }

@router.post("/")
def create_product(data: dict, db: Session = Depends(get_db)):
    # Ensure category exists or create it
    cat = db.query(models.Categoria).filter(models.Categoria.nombre == data.get("categoria", "General")).first()
    if not cat:
        cat = models.Categoria(nombre=data.get("categoria", "General"), descripcion="")
        db.add(cat)
        db.commit()
    
    p = models.Producto(
        categoria_id=cat.id,
        sku=data["sku"],
        nombre=data["nombre"],
        descripcion=data.get("descripcion", ""),
        marca=data.get("marca", ""),
        precio=data["precio"],
    )
    db.add(p)
    db.commit()
    db.refresh(p)
    
    inv = models.Inventario(
        producto_id=p.id,
        stock_actual=data.get("stock", 0),
        stock_minimo=data.get("stock_minimo", 5),
    )
    db.add(inv)
    db.commit()
    return {"id": p.id, "nombre": p.nombre}

@router.put("/{product_id}")
def update_product(product_id: int, data: dict, db: Session = Depends(get_db)):
    p = db.query(models.Producto).filter(models.Producto.id == product_id).first()
    if not p:
        raise HTTPException(status_code=404, detail="Product not found")
    if "nombre" in data: p.nombre = data["nombre"]
    if "descripcion" in data: p.descripcion = data["descripcion"]
    if "marca" in data: p.marca = data["marca"]
    if "precio" in data: p.precio = data["precio"]
    if "stock" in data:
        inv = db.query(models.Inventario).filter(models.Inventario.producto_id == p.id).first()
        if inv: inv.stock_actual = data["stock"]
    db.commit()
    return {"message": "Product updated"}

@router.delete("/{product_id}")
def delete_product(product_id: int, db: Session = Depends(get_db)):
    p = db.query(models.Producto).filter(models.Producto.id == product_id).first()
    if not p:
        raise HTTPException(status_code=404, detail="Product not found")
    p.activo = False
    db.commit()
    return {"message": "Product deactivated"}
