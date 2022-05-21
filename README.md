# SLiMS OAuth Plugin

![preview.png](./assets/images/preview.png) 

# NB : SLiMS anda wajib sudah online dan menggunakan koneksi https

Indonesia
### Cara install
1. Memiliki akun Google seperti Gmail
2. Buka laman https://console.cloud.google.com/projectselector2/apis/dashboard
3. Maka akan muncul seperti berikut:
![1.png](./assets/images/docs/1.png) centang bagian kotak merah dan click "Agree and Continue"
4. Klik tombol create project (apabila anda belum memiliki/membuat projek dilaman tersebut)
![2.png](./assets/images/docs/2.png)
5. Isi isian yang disediakan, lalu klik "Create Project"
![3.png](./assets/images/docs/3.png)
6. Setelah projek berhasil dibuat, maka akan muncul tampilan seperti berikut:
![4.png](./assets/images/docs/4.png)
7. Selanjutnya kita akan membuat "Credential" untuk website kita. Klik "Create Credential" dan pilih "OAuth Client Id"
![5.png](./assets/images/docs/5.png)
8. Apabila anda belum membuat "OAuth Consent Screen" maka akan muncul tampil seperti berikut
![6.png](./assets/images/docs/6.png)
klik "Configure Consent Screen"
9. Pilih bagian "External" lalu klik "Create"
![7.png](./assets/images/docs/7.png)
10. isi form yang disediakan, ketika pada isian yang tersedia terdapat karakter "*" maka wajib diisi.
![8.png](./assets/images/docs/8.png)
11. Pada langkah ke 10, "scroll" ke bawah maka akan muncul isian seperti berikut:
![9.png](./assets/images/docs/9.png)
isi kontak tersebut dengan alamat Email anda atau petugas yang akan mengelola pertanyaan terkait layanan ini. Setelah itu klik "Save and Continue"
12. Pada bagian ini lanjut saja dengan klik "Save and Continue"
![10.png](./assets/images/docs/10.png)
13. Pada bagian ini lanjut saja dengan klik "Save and Continue"
![11.png](./assets/images/docs/11.png)
14. Pada bagian ini "scroll" ke bawah lalu klik "Back to Dashboard"
![12.png](./assets/images/docs/12.png)
15. Maka akan muncul tampilan seperti berikut:
![13.png](./assets/images/docs/13.png)
lalu klik menu "Credential"
16. Maka muncul tampilan seperti berikut dan pilih menu "Web Application":
![14.png](./assets/images/docs/14.png)
17. Isi isian yang tersedia. ketika pada isian yang tersedia terdapat karakter "*" maka wajib diisi.
![15.png](./assets/images/docs/15.png)
18. "Scroll" ke bawah pada bagian "Authorized redirect URLs" klik "Add Url"
![16.png](./assets/images/docs/16.png)
19. Fungsi pada opsi ini adalah untuk menentukan "url callback" mana yang diijinkan oleh kita untuk dapat memproses "response" dari Google setelah proses otentikasi OAuth selesai.
![17.png](./assets/images/docs/17.png)
Url bisa lebih darai satu.
20. Setelah berhasil maka akan muncul tampilan seperti berikut:
![18.png](./assets/images/docs/18.png)
salin isian "ClientID" dan "ClientSecret"
21. Aktifkan plugin SLiMS OAuth yang sudah diunduh dan diekstrak pada folder plugins/ di modul Sistem menu Plugin
![19.png](./assets/images/docs/19.png)
22. Setelah itu tekan F5 atau "refresh" halaman SLiMS. Setelah itu "scoll" kebawah maka akan muncul menu "OAuth". Untuk memasukan "ClientID" dan "ClientSecret", klik link "Config"
![20.png](./assets/images/docs/20.png)
23. Maka akan muncul tampilan seperti berikut:
![21.png](./assets/images/docs/21.png)
24. Isi sesuai dengan data yang ada pada langkah **20** dan untuk "Redirect Url" ada pada langkah **19**. Untuk isian "Message for new Member" anda bisa mengisi sendiri, karena isian itu digunakan untuk menapilkan pesan setelah User melakukan pasca login pertama kali dengan akun google mereka.
![24.png](./assets/images/docs/24.png)
25. Apabila pada langkah **20** anda lupa tidak mencatat, maka anda dapat melihat "Client ID" dan "Client Secreet" pada menu "Credential" lalu pada profil "OAuth 2.0 Client IDs" klik pada nama profile nya
![22.png](./assets/images/docs/22.png)
26. Setelah itu pada pojok kanan atas, terdapat "ClientId" dan "ClientSecret"
![22.png](./assets/images/docs/23.png)
Setelah itu kembali ke langkah **23** lalu klik Simpan
27. Buka laman SLiMS anda : https:/{alamat-slims-online-anda}/?p=member, atau masuk ke menu memberarea
![25.png](./assets/images/docs/25.png)
28. Klik "Login With Google", maka akan muncul tampilan seperti berikut:
![26.png](./assets/images/docs/26.png)
lalu pilihlah akun yang akan anda gunakan.
29. Apabila login berhasil maka "Member" tersebut akan langsung "login", akan tetapi status keanggotaannya masih "Pending" atau tertunda karena perlu di atur data-data pendukung yang lain seperti tipe anggota dll.
![27.png](./assets/images/docs/27.png)
Terdapat pesan yang sudah diatur pada langkah **24**.
28. Apabila telah diaktifasi atau status "Tunda" nya sudah dihilangkah maka akun anggota tersebut sudah aktif dan  dapat digunakan untuk trasansaki dll. Selajutnya anggota tersebut dapat login dengan akun google nya, Jadi akun anggota tersebut tidak memiliki password yang tersimpan di SLiMS anda
![28.png](./assets/images/docs/28.png)

I hope you enjoy with this plugin 😊