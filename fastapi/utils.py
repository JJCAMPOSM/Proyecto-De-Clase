from jose import jwt
from datetime import datetime, timedelta
import hashlib
from passlib.context import CryptContext
from passlib.exc import UnknownHashError

SECRET_KEY = "macuin_super_secret_key_change_in_prod"
ALGORITHM = "HS256"

pwd_context = CryptContext(schemes=["pbkdf2_sha256", "bcrypt"], deprecated="auto")


def get_password_hash(password: str) -> str:
    return pwd_context.hash(password)


def verify_password(plain_password: str, hashed_password: str) -> bool:
    try:
        return pwd_context.verify(plain_password, hashed_password)
    except UnknownHashError:
        # Legacy support for older SHA256 hashes
        return hashlib.sha256(plain_password.encode('utf-8')).hexdigest() == hashed_password
    except Exception:
        return False


def create_access_token(data: dict):
    to_encode = data.copy()
    expire = datetime.utcnow() + timedelta(minutes=1440)  # 24 horas
    to_encode.update({"exp": expire})
    return jwt.encode(to_encode, SECRET_KEY, algorithm=ALGORITHM)
