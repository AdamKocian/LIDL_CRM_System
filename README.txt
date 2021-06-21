Priečinok obsahuje okrem kódu export databázy (database/lidl_db.sql), ktorá pre fungovanie musí byť importovaná a prepojená.

    V tejto verzií používajú prepojenie s databázou súbory:

        db_connect.php
        calendar/load.php
        calendar/insert.php
        calendar/update.php
        calendar/delete.php
        occupancy/_db.php


    Prihlasovacie údaje:

        Manažér 
            email: manazer@manazer.com
            heslo: manazer123
        Dávid Krátky (právomoci manažéra)
            email: david.kratky.sk@gmail.com
            heslo: manazer123

        Zamestnanec 
            email: zamestnanec@zamestnanec.com
            heslo: zamestnanec123


        Stážista - vidí len ovládací panel a tímy (nevidí používateľov a reporty)
            email: stazista@stazista.com
            heslo: stazista123

UPDATE category_lis` SET category_colo` = '#0078FF' WHERE category_list.id = 5;
