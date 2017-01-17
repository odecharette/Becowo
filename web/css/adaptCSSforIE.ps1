$oldfile = "C:\wamp64\www\Becowo\web\css\main.css" 
$newfile = "C:\wamp64\www\Becowo\web\css\mainForIE.css"

$text = (Get-Content -Path $oldfile -ReadCount 0) -join "`n"

$text -replace "var\(--my-blue\)", "rgb(32, 56, 94)" -replace "var\(--my-red\)", "rgb(231, 46, 70)" -replace "var\(--my-grey\)", "rgb(140, 142, 144)" -replace "var\(--my-grey-light\)", "rgb(233, 233, 233)" -replace "var\(--my-black\)", "rgb(36, 38, 46)" -replace "var\(--my-green\)", "rgb(0, 161, 154)" -replace "var\(--my-green-strong\)", "rgb(0, 135, 142)" -replace "var\(--my-pink\)", "rgb(241, 95, 104)" -replace "var\(--my-orange\)", "rgb(244, 147, 2)" | Set-Content -Path $newfile

$oldfile = "C:\wamp64\www\Becowo\web\css\form-elements.css" 
$newfile = "C:\wamp64\www\Becowo\web\css\form-elementsForIE.css"

$text = (Get-Content -Path $oldfile -ReadCount 0) -join "`n"

$text -replace "var\(--my-blue\)", "rgb(32, 56, 94)" -replace "var\(--my-red\)", "rgb(231, 46, 70)" -replace "var\(--my-grey\)", "rgb(140, 142, 144)" -replace "var\(--my-grey-light\)", "rgb(233, 233, 233)" -replace "var\(--my-black\)", "rgb(36, 38, 46)" -replace "var\(--my-green\)", "rgb(0, 161, 154)" -replace "var\(--my-green-strong\)", "rgb(0, 135, 142)" -replace "var\(--my-pink\)", "rgb(241, 95, 104)" -replace "var\(--my-orange\)", "rgb(244, 147, 2)" | Set-Content -Path $newfile
