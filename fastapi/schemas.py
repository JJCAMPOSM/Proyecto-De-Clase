from pydantic import BaseModel, EmailStr, Field
from typing import Optional, List
from datetime import datetime
from decimal import Decimal

class UserAuth(BaseModel):
    email: EmailStr
    password: str = Field(..., min_length=8)

class UserCreate(UserAuth):
    nombre: str
    apellidos: str
    telefono: Optional[str] = None
    rol_id: int

class UserResponse(BaseModel):
    id: int
    email: str
    nombre: str
    apellidos: str
    rol_id: int
    
    class Config:
        from_attributes = True

class Token(BaseModel):
    access_token: str
    token_type: str
    user: UserResponse

class OrderItemCreate(BaseModel):
    producto_id: int
    cantidad: int

class OrderCreate(BaseModel):
    usuario_id: int
    tipo_cliente: str
    notas: Optional[str] = None
    direccion_envio: Optional[str] = None
    productos: List[OrderItemCreate]

class ProductResponse(BaseModel):
    id: int
    sku: str
    nombre: str
    descripcion: Optional[str] = None
    marca: Optional[str] = None
    precio: Decimal
    
    class Config:
        from_attributes = True
