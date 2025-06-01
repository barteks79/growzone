# Todo List

Taski zapisujemy według poniższego wzoru ↓

```
Nazwa funkcjonalności + (backend/frontend/database) ✓

- [x] Task ukończony
- [ ] Task do zrobienia
```

> [!IMPORTANT]
> W commicie dodawaj informację o updacie dokumentacji.

---

### Bartosz Sarnowski

1. `Logowanie (backend)`

    - [x] walidacja danych z POSTa
    - [x] sprawdzenie zgodności danych z użytkownikiem
    - [x] dodanie redirectów z parametrami get, które mówią co poszło w logowaniu nie tak
    - [x] implementacja pobierania użytkownika z DB

2. `Akcje koszyka (backend)`

    - [ ] plik z funkcjonalnością dodawania przedmiotow
        - [x] dodać logike php
        - [ ] dodać logikę db
    - [ ] plik z funkcjonalnością usuwania przedmiotow
        - [x] dodać logike php
        - [ ] dodać logikę db
    - [ ] plik z funkcjonalnością usuwania wszystkich przedmiotow (czyszczenia)
        - [x] dodać logike php
        - [ ] dodać logikę db

3. `Mailer (frontend)`

    - [x] stworzyć UI dla strony reset request
    - [ ] stworzyć UI dla strony reset password

---

### Bartosz Rymer

- [x] resetowanie hasła

---

### Aleksandra Jarema

```sql 
INSERT INTO nazwa_tabeli (klucz_podstawowy, ..., klucz_obcy) VALUES (1, ..., 3);
```

1. `Inserty`

   - [ ] dodaj do tych wstawianych wartości klucze obce i podstawowe  

2. `Zapytania SQL`
   
   - [ ] wszystkie produkty
   - [ ] koszyki dla uzytkownika (po user_id)
   - [ ] produkt nalezacy do koszyka (po cart_id)
