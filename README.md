# mantas-kemesius/FTPClientPHP

FTP Client on PHP language.

## Install

  * Use composer: _require_ `mantas-kemesius/FTPClientPHP`

  * Or use GIT clone command: `git clone git@github.com:mantas-kemesius/FTPClientPHP.git`
## Prepare:
  * Add your ftp server info to parameters.yml file (make parameters.yml file from parameters.yml.dist file)
## Commands:

```
bye             užbaigti ftp sesiją
cd              pakeisti dabartinę direktoriją serveryje
cdup            pakeisti dabartinę direktoriją serveryje pereinant į tėvinę
chmod           pakeisti serveryje esančio failo teises
close           užbaigti ftp sesiją
delete          ištrinti failą serveryje
dir             rodyti esamosios serverio direktorijos turinį
disconnect      užbaigti ftp sesiją
get             inicijuoti failo siuntimą iš serverio
help            rodyti pagalbą
lcd             pakeisti dabartinę direktoriją kliente
ls              rodyti esamosios serverio direktorijos turinį
mdelete         ištrinti keletą failų serveryje
mget            inicijuoti kelių failų siuntimą iš serverio
mkdir           sukurti direktoriją serveryje
mode            pakeisti failų siuntimo režimą
mput            siųsti į serverį keletą failų
open            inicijuoti jungimąsi prie serverio
put             siųsti į serverį failą
pwd             rodyti serverio dabartinę direktoriją
quit            užbaigti ftp sesiją
recv            inicijuoti failo siuntimą iš serverio
rename          pervadinti failą serveryje
restart         pakartoti failo siuntimą nuo tam tikros vietos
rmdir           ištrinti direktoriją serveryje
send            siųsti vieną failą
user            inicijuoti prisijungimą prie serverio
```

#### Or just run ```help``` in console
