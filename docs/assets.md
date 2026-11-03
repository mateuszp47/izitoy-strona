# Materiały IZITOY

Źródła przekazane przez właściciela projektu:
- Niebieska: https://www.olx.pl/d/oferta/mobilna-toaleta-budowlana-toi-toi-duza-na-dzialke-wc-ubikacja-pisuar-slawojka-wychodek-CID628-ID1bIo4K.html
- Szara: https://www.olx.pl/d/oferta/toaleta-mobilna-pisuar-toi-toi-wc-budowlana-szara-na-dzialke-duza-ubikacja-slawojka-wychodek-CID628-ID1cup2I.html

Pliki lokalne w `public/assets`; strona nie korzysta z hotlinkowania do OLX.
- `toalety.webp`: retusz AI dwóch kabin na spójnym tle.
- `toaleta-niebieski.webp`, `toaleta-szary.webp`: widoki pojedyncze z retuszu.
- Pozostałe sześć pliki WebP: dodatkowe widoki oryginalne z OLX, konwersja i optymalizacja bez generowania cech produktu.

Narzędzie: wbudowane imagegen. Główny prompt: poprawa ostrości, światła i tła obu oryginalnych fotografii; pełne kabiny obok siebie, zachowanie proporcji, paneli, dachu, okuć, zamków i rzeczywistych kolorów; bez napisów i dodatkowych elementów. Korekta retuszu: zachowanie szarego koloru podstawy wariantu szarego zgodnie z oryginałem.

Weryfikacja zdjęć z fizycznym produktem należy do sprzedawcy przed publicznym uruchomieniem.

## Obróbka z 3 listopada 2026

Narzędzie: wbudowane imagegen, następnie optymalizacja WebP (maksymalnie 1600 px, jakość 92).

- `toaleta-szary-white.webp`: zdjęcie katalogowe na białym tle.
- `szary-detal-white.webp`: widok boczny, usunięte tło placu.
- `szary-otwarta-white.webp`: widok frontu, usunięte tło placu (nazwa historyczna; drzwi zamknięte).
- `szary-wnetrze-white.webp`: wnętrze po neutralizacji żółtego zafarbu światła; zachowane wyposażenie.
- `toalety.webp`: wspólne zdjęcie obu kolorów na białym tle.

Polecenia retuszu: zmiana tła na czystą biel #FFFFFF, subtelny cień kontaktowy, zachowanie kąta zdjęcia, koloru, konstrukcji, drzwi, okuć i wyposażenia kabiny; usunięcie tła placu oraz tymczasowych opakowań i zabrudzeń. Dla wnętrza: neutralny balans bieli, bez usuwania ścian ani wyposażenia. Dla zdjęcia wspólnego: zmiana wyłącznie tła i zachowanie obu kabin. Retusz nie dodaje nowych wariantów produktu.
