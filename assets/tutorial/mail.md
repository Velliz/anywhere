## Mail

#### Konfigurasi Dasar

Untuk mengirim e-mail buatlah sebuah template dengan melakukan klik **New MAIL** 
Kemudian lakukan konfigurasi sesuai kebutuhan pada halaman template. 
Berikut ini beberapa konfigurasi template untuk SMTP e-mail.

#### Konfigurasi Template

email name	string	Nama email akan digunakan sebagai nama pengirim e-mail
email host	string	Hostname dari layanan penyedia akun e-mail
email port	string	nomor PORT SMTP dari layanan penyedia akun e-mail
email username	string	username akun e-mail
email password	string	password akun e-mail
CSS from CDN	url	Alamat cdn CSS misal: <link href="http://example.com/assets/global/css/bootstrap.css" rel="stylesheet">
data source type	radio button	POST - untuk mengirim data ke Anywhere. Dapat mengunakan AnywhereWrapper
URL - Anywhere akan membuka url untuk mendapatkan data
url data source here	url	Alamat untuk mengunduh data. Isi jika memilih data source type URL
SMTP Auth	select	true atau false
SMTP Secure	select	TLS atau SSL
API url	url	Untuk melakukan request pengiriman e-mail
.html designer	file	Designer template tampilan e-mail menggunakan HTML. Tidak perlu menuliskan ulang tag html, head, body. HTML designer menggunakan aturan Puko Template Engine (PTE) yang dapat kamu lihat di sini
.css designer	file	Designer template tampilan e-mail menggunakan CSS. Otomatis terhubung dengan .html designer
.json data sample

#### Konfigurasi Kode

Untuk mengirim e-mail download AnywhereWrapper Kemudian kamu bisa mengirim e-mail dengan kode seperti contoh berikut:

```php
require 'Wrapper.php';

$mail = new AnywhereMail(Wrapper::POST);
$mail->setTo('example@gmail.com');
$mail->setCc('example@outlook.com');
$mail->setBcc('example@yahoo.co.id');

$mail->setSubject('Anywhere Wrapper');
$mail->setValue('Name', 'Anywhere');
$mail->setValue('Age', '22');

$mail->setAttachment('qrcode.png', 'http://oaas-divelliz.rhcloud.com/qr/render?data=admin@example.co.id');
$mail->setAttachment('qrcode1.png', 'http://oaas-divelliz.rhcloud.com/qr/render?data=developer@example.co.id');

$mail->Send(API_URL);
```

Perhatian: biasanya e-mail memerlukan waktu beberapa menit agar dapat sampai ke alamat tujuan.

Jika request berhasil maka email akan terkirim ke alamat yang dimasukan pada bagian setTo().
