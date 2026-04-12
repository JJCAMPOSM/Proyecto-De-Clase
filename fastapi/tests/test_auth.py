import pytest
from fastapi.testclient import TestClient
from main import app
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
import models

# Use in-memory SQLite for tests
TEST_DATABASE_URL = "sqlite:///./test.db"
engine = create_engine(TEST_DATABASE_URL, connect_args={"check_same_thread": False})
TestingSessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)

client = TestClient(app)

@pytest.fixture(scope="module")
def db():
    # Create tables
    models.Base.metadata.create_all(bind=engine)
    db = TestingSessionLocal()
    # Seed test user
    test_user = models.Usuario(
        rol_id=1,
        nombre="Test",
        apellidos="User",
        email="test@example.com",
        telefono="1234567890",
        password_hash="$2b$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LeCt1uB0w/4oJcKm"  # "password"
    )
    db.add(test_user)
    db.commit()
    yield db
    # Teardown
    db.close()
    models.Base.metadata.drop_all(bind=engine)

def test_login_success(db):
    response = client.post("/api/auth/login", json={"email": "test@example.com", "password": "password"})
    assert response.status_code == 200
    data = response.json()
    assert "access_token" in data
    assert data["token_type"] == "bearer"

def test_login_invalid_password(db):
    response = client.post("/api/auth/login", json={"email": "test@example.com", "password": "wrong"})
    assert response.status_code == 401
    assert "Incorrect email or password" in response.json()["detail"]

def test_login_nonexistent_user(db):
    response = client.post("/api/auth/login", json={"email": "nonexistent@example.com", "password": "password"})
    assert response.status_code == 401
    assert "Incorrect email or password" in response.json()["detail"]