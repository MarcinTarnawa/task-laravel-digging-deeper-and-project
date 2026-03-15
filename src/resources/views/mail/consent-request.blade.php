<x-mail::message>
# Dzień dobry, {{ $customer->name }}!

Chcemy wysłać do Ciebie fakturę drogą elektroniczną. Ze względów bezpieczeństwa oraz aby uniknąć pomyłek, prosimy o jednorazowe potwierdzenie chęci otrzymywania dokumentów na ten adres email.

Kliknij poniższy przycisk, aby wyrazić zgodę:

<x-mail::button :url="$consentUrl">
Potwierdzam i chcę otrzymać fakturę
</x-mail::button>

Jeśli to pomyłka i nie spodziewasz się żadnych dokumentów od nas, po prostu zignoruj tę wiadomość.

Dziękujemy,<br>
{{ config('app.name') }}
</x-mail::message>