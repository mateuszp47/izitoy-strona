<?php
return [
 'required'=>'Pole :attribute jest wymagane.', 'email'=>'Wpisz poprawny adres e-mail w polu :attribute.',
 'accepted'=>'Zaakceptuj informację w polu :attribute.', 'string'=>'Pole :attribute musi zawierać tekst.',
 'integer'=>'Pole :attribute musi być liczbą całkowitą.', 'numeric'=>'Pole :attribute musi być liczbą.',
 'min'=>['numeric'=>'Pole :attribute musi mieć wartość co najmniej :min.','string'=>'Pole :attribute musi mieć minimum :min znaków.'],
 'max'=>['numeric'=>'Pole :attribute może mieć wartość do :max.','string'=>'Pole :attribute może mieć maksymalnie :max znaków.','file'=>'Plik :attribute może mieć maksymalnie :max kB.','array'=>'Pole :attribute może zawierać maksymalnie :max elementów.'],
 'size'=>['string'=>'Nieprawidłowa wartość pola :attribute.'],
 'exists'=>'Wybrana wartość pola :attribute jest nieprawidłowa.', 'in'=>'Wybrana wartość pola :attribute jest nieprawidłowa.',
 'image'=>'Plik :attribute musi być zdjęciem.', 'mimes'=>'Dozwolone formaty pliku :attribute: :values.',
 'array'=>'Pole :attribute ma nieprawidłowy format.',
 'attributes'=>['name'=>'imię i nazwisko','email'=>'e-mail','phone'=>'telefon','city'=>'miejscowość','quantity'=>'liczba sztuk','message'=>'wiadomość','privacy'=>'polityka prywatności','product_id'=>'wariant','price_gross'=>'cena brutto','description'=>'opis','image'=>'zdjęcie główne','gallery'=>'galeria','delivery'=>'informacja o dostawie'],
];
