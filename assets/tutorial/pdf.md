## PDF

#### Konfigurasi Dasar

Untuk mengenerate sebuah halaman PDF buatlah sebuah template dengan melakukan klik **New PDF** 
Kemudian lakukan konfigurasi sesuai kebutuhan pada halaman template. 
Berikut ini beberapa konfigurasi template untuk PDF.

#### Konfigurasi Template

- Report name (string)
Sesuaikan dengan nama laporan yang dibuat

- Paper type (radio button)
F4, A4, B5

- data source type (radio button)
POST - untuk mengirim data ke Anywhere. Dapat mengunakan AnywhereWrapper
URL - Anywhere akan membuka url untuk mendapatkan data

- CSS from CDN (url)
Alamat cdn CSS misal: `<link href="http://example.com/assets/global/css/bootstrap.css" rel="stylesheet">`

- url data source here (url)
Alamat untuk mengunduh data. Isi jika memilih data source type URL

- file output (radio button)
Buka langsung di Browser atau Download. Jika menggunakan AnywhereWrapper data otomatis di buka langsung di Browser

- API url
Untuk melakukan request laporan PDF

- .html designer
Designer template laporan PDF menggunakan HTML. Tidak perlu menuliskan ulang tag html, head, body. HTML designer menggunakan aturan Puko Template Engine (PTE) yang dapat kamu lihat di sini

- .css designer
Designer template laporan PDF menggunakan CSS. Otomatis terhubung dengan .html designer

- .json data sample
Menyediakan data contoh untuk pengembangan pada tahap design HTML dan CSS

#### Konfigurasi Kode

Untuk membuat request PDF download AnywhereWrapper Kemudian kamu bisa menuliskan kodenya seperti contoh berikut:

```php
require 'Wrapper.php';

$pdf = new Pdf(Wrapper::POST);
$pdf->setValue('Name', 'Someone');
$pdf->setValue('Age', '22');
$pdf->Send(API_URL);
```

Jika request berhasil maka browser akan menampilkan file PDF sesuai dengan template dan data.
