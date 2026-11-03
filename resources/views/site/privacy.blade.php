@extends('site.layout')
@section('title','Polityka prywatności | IZITOY')
@section('content')
<article class="wrap prose section">
<div class="eyebrow">TWOJE DANE · IZITOY.PL</div>
<h1>Polityka prywatności</h1>
<p>Aktualizacja: 3 listopada 2026 r. Dokument opisuje przetwarzanie danych podczas korzystania z izitoy.pl, wysyłania zapytań o toalety przenośne oraz korzystania z panelu administracyjnego.</p>
<h2>1. Administrator i kontakt</h2>
@if($site['company'] && $site['address'] && $site['email'])
<p>Administratorem danych osobowych jest {{ $site['company'] }}, z adresem {{ $site['address'] }}@if($site['nip']), NIP {{ $site['nip'] }}@endif. W sprawach ochrony danych, w tym realizacji praw opisanych poniżej, skontaktuj się z nami pod adresem <a href="mailto:{{ $site['email'] }}">{{ $site['email'] }}</a> lub pisemnie na powyższy adres.</p>
@else
<p>Dane administratora serwisu wymagają uzupełnienia przez właściciela przed publicznym uruchomieniem formularza: pełna nazwa firmy, adres oraz e-mail kontaktowy. Dane te są pobierane z ustawień serwisu.</p>
@endif
<h2>2. Zakres zbieranych danych</h2>
<p>W formularzu zapytania zbieramy imię i nazwisko, adres e-mail, wybrany produkt, liczbę sztuk i treść wiadomości, a jeśli je podasz — numer telefonu oraz miejscowość dostawy. Zapisujemy datę wysłania zapytania i potwierdzenia zapoznania się z informacją o prywatności. Prosimy, aby nie podawać w wiadomości danych wrażliwych ani danych osób trzecich, które nie są potrzebne do obsługi sprawy.</p>
<p>Podczas korzystania z serwisu serwer może zapisywać dane techniczne, takie jak adres IP, czas połączenia, adres żądanej strony, informacje o przeglądarce i systemie oraz błędy. W panelu przetwarzamy dane kont administratorów i dane sesji logowania.</p>
<h2>3. Cele i podstawy przetwarzania</h2>
<ul>
<li>Przygotowanie odpowiedzi dotyczącej produktu, ceny i dostawy oraz działania przed zawarciem umowy na Twoje żądanie — art. 6 ust. 1 lit. b RODO.</li>
<li>Obsługa pozostałej korespondencji i kontynuowanie kontaktu w danej sprawie — art. 6 ust. 1 lit. f RODO. Uzasadnionym interesem jest sprawna komunikacja z osobami zainteresowanymi ofertą.</li>
<li>Ochrona serwisu i panelu przed nadużyciami, zapewnienie działania formularzy, diagnozowanie błędów i ustalenie lub obrona roszczeń — art. 6 ust. 1 lit. f RODO.</li>
</ul>
<p>Wysłanie formularza jest zapytaniem i nie oznacza zawarcia umowy ani obowiązku zapłaty. Potwierdzenie zapoznania się z polityką nie jest zgodą na marketing. Formularz nie służy zapisowi do newslettera.</p>
<h2>4. Dobrowolność podania danych</h2>
<p>Podanie danych jest dobrowolne. Imię i nazwisko, prawidłowy adres e-mail, wiadomość oraz liczba sztuk są wymagane do obsługi formularza. Telefon i miejscowość są opcjonalne; podanie miejscowości pomaga ustalić koszt transportu. Możesz wysłać zapytanie bez wyboru produktu.</p>
<h2>5. Odbiorcy danych</h2>
<p>Dostęp do danych mają upoważnione osoby obsługujące zapytania oraz dostawcy hostingu, infrastruktury serwerowej, poczty elektronicznej i wsparcia technicznego — wyłącznie w zakresie potrzebnym do świadczenia usług. Dostawcy działający jako podmioty przetwarzające otrzymują dane na podstawie odpowiednich umów. Dane mogą być udostępnione uprawnionym organom, jeżeli wynika to z przepisów. Serwis nie sprzedaje danych ani nie przekazuje ich do marketingu innych firm.</p>
<h2>6. Okres przechowywania</h2>
<p>Zapytania przechowujemy przez czas prowadzenia korespondencji, a następnie do 12 miesięcy od jej zakończenia. Jeśli sprawa prowadzi do zawarcia umowy lub dotyczy roszczeń, odpowiednie dane mogą być przechowywane dłużej — w zakresie wynikającym z przepisów i do upływu właściwych terminów przedawnienia. Dane kont administratorów są przechowywane przez okres utrzymywania konta. Dane techniczne i kopie zapasowe podlegają okresom retencji ustalanym dla rzeczywiście używanych usług serwerowych.</p>
<h2>7. Twoje prawa</h2>
<p>Na zasadach określonych w RODO możesz żądać dostępu do danych i uzyskania ich kopii, sprostowania, usunięcia lub ograniczenia przetwarzania. Prawo do przenoszenia danych przysługuje, gdy dane są przetwarzane automatycznie na podstawie umowy lub zgody, w zakresie przewidzianym prawem. Możesz wnieść sprzeciw z przyczyn związanych z Twoją szczególną sytuacją wobec przetwarzania opartego na uzasadnionym interesie. Jeśli przetwarzanie w przyszłości będzie oparte na zgodzie, możesz ją wycofać bez wpływu na zgodność wcześniejszego przetwarzania z prawem.</p>
<p>Żądanie skieruj na dane kontaktowe administratora. Możemy poprosić o informacje niezbędne do potwierdzenia tożsamości. Masz także prawo wniesienia skargi do Prezesa Urzędu Ochrony Danych Osobowych.</p>
<h2>8. Cookies i pamięć przeglądarki</h2>
<p>Serwis wykorzystuje niezbędne pliki cookie sesji oraz mechanizmy ochrony formularzy przed nieuprawnionymi żądaniami. Służą one m.in. zachowaniu sesji, logowaniu administratorów i poprawnemu wyświetlaniu wyniku wysłania formularza. Czas działania sesji zależy od konfiguracji serwera; domyślnie wynosi 120 minut bezczynności. Obecna wersja serwisu nie zawiera narzędzi analitycznych, pikseli reklamowych ani zewnętrznych czcionek śledzących.</p>
<p>Cookies możesz usuwać lub blokować w ustawieniach przeglądarki. Wyłączenie niezbędnych cookies może uniemożliwić wysyłanie formularzy i logowanie do panelu.</p>
<h2>9. Przekazywanie danych i decyzje automatyczne</h2>
<p>Formularz zapisuje dane w bazie serwisu, a powiadomienie może być przesyłane przez skonfigurowany serwer pocztowy. Serwis nie zawiera integracji wysyłających treść zapytań do platform reklamowych ani narzędzi AI. Informacja o ewentualnym przekazywaniu danych poza Europejski Obszar Gospodarczy zależy od wybranego dostawcy hostingu i poczty i wymaga potwierdzenia przed uruchomieniem usług. Dane nie służą profilowaniu ani podejmowaniu decyzji wywołujących skutki prawne wyłącznie w sposób zautomatyzowany.</p>
<h2>10. Zmiany dokumentu</h2>
<p>Politykę aktualizujemy wraz ze zmianami działania serwisu lub sposobu przetwarzania danych. Aktualna wersja jest dostępna pod tym adresem, a data aktualizacji znajduje się na początku dokumentu.</p>
</article>
@endsection
