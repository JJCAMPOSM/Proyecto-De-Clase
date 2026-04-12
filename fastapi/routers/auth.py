from fastapi import APIRouter, Depends, HTTPException, status, Request
from sqlalchemy.orm import Session
from database import get_db
from slowapi import Limiter
from slowapi.util import get_remote_address
import models
import schemas
from utils import verify_password, create_access_token

router = APIRouter()

limiter = Limiter(key_func=get_remote_address)

@router.post("/login", response_model=schemas.Token)
@limiter.limit("5/minute")
def login(request: Request, auth_data: schemas.UserAuth, db: Session = Depends(get_db)):
    user = db.query(models.Usuario).filter(models.Usuario.email == auth_data.email).first()
    if not user or not verify_password(auth_data.password, user.password_hash):
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail="Incorrect email or password",
        )
    if not user.activo:
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="User is inactive",
        )
    
    access_token = create_access_token(data={"sub": str(user.id), "rol_id": user.rol_id})
    return {
        "access_token": access_token, 
        "token_type": "bearer",
        "user": user
    }
