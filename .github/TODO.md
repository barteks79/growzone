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
    - [x] stworzyć UI dla strony reset password

---

### Bartosz Rymer

-   [x] rejestracja (backend)
-   [x] resetowanie hasła

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

### Piotr Lesiak

1. `Wyszukiwanie (frontend)`

    - [ ] design strony
    - [ ] wyszukiwanie po nazwie produktu (słowa kluczowe)
    - [ ] filtrowanie kategorii produktów
    - [ ] filtrowanie po cenie produktu (widełki)
    - [ ] filtrowanie po dostępności produktu
    - [ ] paginacja ??

2. `Strona produktu (frontend)`

    - [ ] design strony
    - [ ] interaktywne zdjęcia produktu
    - [ ] dodawanie do koszyka

3. `Koszyk (frontend)`

    - [ ] design strony
    - [ ] interakcja z produktami (dodawanie, usuwanie)
    - [ ] usuwanie całego koszyka
    - [ ] zamawianie
    - [ ] formularz z adresem użytkownika

4. `Historia zamówień (frontend)`

    - [ ] design strony
    - [ ] możliwość ponownego zamówienia
    - [ ] usuwanie z historii

5. `Ustawienia użytkownika (frontend)`

    - [ ] design strony
    - [ ] formularz zmiany imiona, nazwiska, hasła
    - [ ] kastomizacja koloru & obrazu profilu
    - [ ] zmiana email'a ??

6. `Panel admina (frontend)`

    - [ ] design strony
    - [ ] dodawanie produktów (również zdjęć)
    - [ ] edycja produktów
    - [ ] zarządzanie użytkownikami

7. `Mail z resetowaniem hasła (frontend)`

    - [ ] design mail'a
    - [ ] [ukryty link do wirusa](https://youareanidiot.cc)
