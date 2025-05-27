# Guidelines

Stosujemy się do zasad, aby każdy rozumiał kod.

1. **Nazywanie Zmiennych**

    ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
    ![MySQL](https://img.shields.io/badge/mysql-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white)

    ```diff

    # korzystamy z snake case
    - $isGay = true;
    - $IsGay = true;
    + $is_gay = true;

    # tylko pozytywne zmienne boolean'owe
    - $is_not_homosexual = false;
    + $is_homosexual = true;

    # konkretnie
    - $is_informatyk = false;
    + $has_girlfriend = false;
    ```

2. **Struktura katalogów**

    ![Visual Studio Code](https://img.shields.io/badge/Visual%20Studio%20Code-0078d7.svg?style=for-the-badge&logo=visual-studio-code&logoColor=white)
    ![Apache](https://img.shields.io/badge/apache-%23D42029.svg?style=for-the-badge&logo=apache&logoColor=white)

    Strony są w plikach index.php

    ```
    ├── pages
    │   └── sign-in
    │       └── index.php
    ├── php
    │   └── db.php
    ```

3. **Nazywanie commitów**

    ![Git](https://img.shields.io/badge/git-%23F05033.svg?style=for-the-badge&logo=git&logoColor=white)
    ![GitHub](https://img.shields.io/badge/github-%23121011.svg?style=for-the-badge&logo=github&logoColor=white)

    ```bash
    <nazwa funkcjonalności/strony>: <wiadomość w formie dokonanej bezosobowej>
    # koszyk: zaimplementowano usuwanie przedmiotów z koszyka po kliknięciu przycisku Linka (kosza)
    ```
