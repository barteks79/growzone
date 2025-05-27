# PHP Guidelines 

Stosujemy się do zasad, aby każdy rozumiał kod.

1. **Nazywanie Zmiennych**
   
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

   Strony są w plikach index.php

    ```
    ├── pages 
    │   └── sign-in
    │       └── index.php
    ├── php
    │   └── db.php 
   ```
