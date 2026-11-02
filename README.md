# IZITOY — toalety przenośne

Strona sprzedażowa izitoy.pl: Laravel 13, Blade, SQLite, własny responsywny CSS/JS. Dwa warianty kabiny: niebieski i szary. Sprzedaż przez zapytanie; bez koszyka, płatności internetowych i automatycznego zawierania umowy.

## Uruchomienie lokalne

PHP 8.3+, Composer 2, rozszerzenia PHP: SQLite/PDO, mbstring, XML/DOM, fileinfo, ctype, curl, openssl, tokenizer, GD, Phar, zlib. Node i npm nie są wymagane — gotowe zasoby znajdują się w `public/assets`.

```bash
git clone https://github.com/mateuszp47/izitoy-strona.git
cd izitoy-strona
composer run setup
php artisan admin:create twoj-email@example.com
php artisan serve
```

Komenda `admin:create` pyta o hasło w ukrytym polu (minimum 12 znaków). Nie ma domyślnego konta ani hasła. Ponowne uruchomienie dla tego samego adresu zmienia hasło. Strona: http://127.0.0.1:8000, panel: http://127.0.0.1:8000/admin.

Jeśli masz już lokalną kopię: `git pull origin main`, następnie `composer install`, `php artisan migrate --seed`, `php artisan storage:link`. Nie nadpisuj istniejącego `.env` i bazy danych. Seeder dodaje brakujące warianty, zachowując zmienione ceny i opisy.

## Panel /admin

- Edycja nazwy, ceny brutto i opisu dwóch wariantów.
- Ukrywanie/publikowanie produktu; kolory pozostają stałe.
- Zdjęcie główne oraz galeria do 8 zdjęć. JPG, PNG i WebP, do 8 MB na plik. Zdjęcia z panelu zapisują się w `storage/app/public/products`.
- Zapytania: dane klienta, wariant, liczba sztuk, miejscowość, treść i data potwierdzenia informacji o prywatności.
- Statusy: nowe, w obsłudze, zamknięte. Możliwość trwałego usunięcia danych zapytania.
- Dane firmy, kontakt i informacja o transporcie aktualizowane bez edycji kodu.

## Formularz i poczta

Zapytanie najpierw trafia do bazy. Powiadomienie na adres ustawiony w panelu jest wysyłane przez SMTP; błędna konfiguracja poczty nie usuwa zapytania. W panelu widoczny jest wynik wysyłki. Walidacja serwerowa, CSRF, pole antyspamowe i limit 5 wysłań/minutę. Logowanie ma również limit 5 prób/minutę.

Domyślnie `MAIL_MAILER=log`, czyli **brak rzeczywistej wysyłki e-mail**. Przed publikacją ustaw w `.env`:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://izitoy.pl
SESSION_SECURE_COOKIE=true
MAIL_MAILER=smtp
MAIL_HOST=serwer-poczty
MAIL_PORT=587
MAIL_USERNAME=adres-skrzynki
MAIL_PASSWORD=haslo-skrzynki
MAIL_SCHEME=smtp
MAIL_FROM_ADDRESS=adres-skrzynki
MAIL_FROM_NAME=IZITOY
```

Dane skrzynki wpisz na serwerze — nigdy nie zapisuj ich w Git. Po zmianie konfiguracji: `php artisan optimize:clear`, następnie `php artisan config:cache`. Zweryfikuj rzeczywiste doręczenie testowego zapytania.

## Wdrożenie na hosting PHP

1. Zainstaluj zależności `composer install --no-dev --optimize-autoloader`.
2. Utwórz `.env`, ustaw domenę, środowisko produkcyjne, pocztę oraz dane sprzedawcy; wygeneruj klucz tylko dla nowej instalacji: `php artisan key:generate`.
3. Utwórz `database/database.sqlite` i ustaw uprawnienia zapisu dla bazy, `storage` oraz `bootstrap/cache` zgodnie z konfiguracją hostingu.
4. `php artisan migrate --seed --force` oraz `php artisan storage:link`.
5. Ustaw katalog dokumentów domeny wyłącznie na `public/`. Cały projekt i baza muszą pozostać poza publicznym katalogiem dokumentów. Włącz HTTPS.
6. Utwórz administratora, uzupełnij prawdziwą nazwę firmy, adres, NIP, telefon i e-mail w panelu. Strona prywatności pobiera te dane. Przejrzyj jej treść zgodnie z rzeczywistym hostingiem i sposobem obsługi klientów.
7. Sprawdź formularz, dostarczenie powiadomienia, logowanie oraz upload zdjęcia. Przed publicznym startem potwierdź ceny, dostępność i warunki transportu.
8. `php artisan config:cache` i `php artisan view:cache`.

### Dane i kopie zapasowe

Zachowuj `.env` (w tym APP_KEY), `database/database.sqlite` i cały `storage/app/public`. Baza i zdjęcia dodane w panelu nie są wersjonowane w Git. Aktualizacja kodu nie może ich nadpisywać. Wykonuj spójny backup SQLite i plików oraz regularnie testuj przywracanie. Nie uruchamiaj `migrate:fresh` na produkcji.

Zapytania zawierają dane osobowe. Usuwaj zakończone sprawy zgodnie z okresem retencji w polityce prywatności; panel umożliwia ich usunięcie. Kopie zapasowe muszą mieć ustalony cykl wygasania.

## Weryfikacja

```bash
php artisan test
composer validate --no-check-publish
composer audit
```

Testy obejmują publiczne strony, dane strukturalne, formularz i walidację, awarię SMTP, uprawnienia panelu, logowanie, upload zdjęć, ukrywanie produktu, obsługę zapytań i bezpieczne powtórzenie seedera.

## Zdjęcia i treści

Ceny początkowe: 3500 zł brutto/szt. dla obu kolorów, według wskazanych ogłoszeń OLX z 2.11.2026. Opisy przepisane profesjonalnie na podstawie specyfikacji sprzedawcy. Pominięto nieudokumentowane porównania z ABS i twierdzenia o udziale w rynku.

Zdjęcie główne i widoki katalogowe przygotowane narzędziem imagegen z fotografii z ogłoszeń (ujednolicone tło, światło i ostrość). Dodatkowe fotografie z ogłoszeń zachowują rzeczywiste detale; pliki zoptymalizowano do WebP. Przed publikacją należy porównać retusz z faktycznym dostarczanym produktem. Źródła i opis obróbki: `docs/assets.md`.
