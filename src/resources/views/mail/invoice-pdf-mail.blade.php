<x-mail::message>
# Twoja faktura jest gotowa

Dziękujemy za zakupy! Twoja faktura (ID: {{ $invoice->id }}) została wygenerowana i jest gotowa do pobrania. 
Znajdziesz ją również w załączniku do tej wiadomości.

<x-mail::button :url="route('pdf.download', $invoice->id)">
Pobierz fakturę (PDF)
</x-mail::button>

Jeśli masz jakiekolwiek pytania, po prostu odpowiedz na ten e-mail.

Pozdrawiamy,<br>
{{ config('app.name') }}
</x-mail::message>