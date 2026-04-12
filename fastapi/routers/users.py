from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from database import get_db
import models
import schemas
from utils import get_password_hash

router = APIRouter()

@router.post("/external", response_model=schemas.UserResponse)
def create_external_user(user: schemas.UserCreate, db: Session = Depends(get_db)):
    exist = db.query(models.Usuario).filter(models.Usuario.email == user.email).first()
    if exist:
        raise HTTPException(status_code=400, detail="Email already registered")
    
    # 2 es típicamente el ID del cliente externo en el init de la base de datos
    rol_cliente = db.query(models.Role).filter(models.Role.nombre == 'Cliente Externo').first()
    rol_id = rol_cliente.id if rol_cliente else 2

    db_user = models.Usuario(
        email=user.email,
        password_hash=get_password_hash(user.password),
        nombre=user.nombre,
        apellidos=user.apellidos,
        telefono=user.telefono,
        rol_id=rol_id 
    )
    db.add(db_user)
    db.commit()
    db.refresh(db_user)
    return db_user

@router.post("/internal", response_model=schemas.UserResponse)
def create_internal_user(user: schemas.UserCreate, db: Session = Depends(get_db)):
    exist = db.query(models.Usuario).filter(models.Usuario.email == user.email).first()
    if exist:
        raise HTTPException(status_code=400, detail="Email already registered")
        
    db_user = models.Usuario(
        email=user.email,
        password_hash=get_password_hash(user.password),
        nombre=user.nombre,
        apellidos=user.apellidos,
        telefono=user.telefono,
        rol_id=user.rol_id 
    )
    db.add(db_user)
    db.commit()
    db.refresh(db_user)
    return db_user

@router.get("/list", response_model=list[schemas.UserResponse])
def get_users(db: Session = Depends(get_db)):
    return db.query(models.Usuario).all()
