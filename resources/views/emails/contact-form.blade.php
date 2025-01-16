@component('mail::message')
# Yeni İletişim Formu Mesajı

**Gönderen:** {{ $name }}  
**E-posta:** {{ $email }}

**Mesaj:**  
{{ $message }}

@endcomponent 