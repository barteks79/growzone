# Todo List

Taski zapisujemy według poniższego wzoru ↓

```txt
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

    - [x] plik z funkcjonalnością dodawania przedmiotow
        - [x] dodać logike php
        - [x] dodać logikę db
    - [x] plik z funkcjonalnością usuwania przedmiotow
        - [x] dodać logike php
        - [x] dodać logikę db
    - [x] plik z funkcjonalnością usuwania wszystkich przedmiotow (czyszczenia)
        - [x] dodać logike php
        - [x] dodać logikę db

3. `Mailer (frontend)`

    - [x] stworzyć UI dla strony reset request
    - [x] stworzyć UI dla strony reset password

4. `Koszyk (frontend/backend)`

    - [x] stworzyć plik http ktory zwraca id zalogowanego uzytkownika
    - [ ] koszyk i dostawa
       - [x] dodawanie do koszyka po kliknieciu '+'
       - [x] odejmowanie z koszyka po kliknieciu '+'
       - [ ] czyszczenie calego koszyka po kliknieciu ikony
       - [ ] dodac UI wyboru dostawy

---

### Bartosz Rymer

-   [x] rejestracja (backend)
-   [x] resetowanie hasła
-   [x] historia zamówień użytkownika (backend)
-   [x] historia zamówień użytkownika (frontend)

---

### Aleksandra Jarema

```sql
INSERT INTO nazwa_tabeli (klucz_podstawowy, ..., klucz_obcy) VALUES (1, ..., 3);
```

1. `Inserty`

    - [x] dodaj do tych wstawianych wartości klucze obce i podstawowe

2. `Zapytania SQL`

    - [x] wszystkie produkty
    - [x] koszyki dla uzytkownika (po user_id)
    - [x] produkt nalezacy do koszyka (po cart_id)
    - [ ] zliczajace wartosc koszyka dla danego uzytkownika 
