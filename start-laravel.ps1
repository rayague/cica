# Script Laravel CICA INSTANTANE
# A placer dans C:\Users\hp\Documents\cica\start-laravel-instant.ps1

# Variables rapides
$projectPath = "C:\Users\hp\Documents\cica"
$serverUrl = "http://127.0.0.1:8000"

# Aller au projet
Set-Location $projectPath

# Check si deja ouvert (1 seconde max)
try {
    $response = Invoke-WebRequest -Uri $serverUrl -TimeoutSec 1 -ErrorAction SilentlyContinue
    if ($response.StatusCode -eq 200) {
        # OUVERTURE INSTANTANEE
        Start-Process $serverUrl
        exit 0
    }
} catch { }

# Si pas ouvert, demarrage rapide
Write-Host "🚀 Demarrage..." -ForegroundColor Green

# Verifier MySQL (1 ligne)
if (-not (Get-Process mysqld -ErrorAction SilentlyContinue)) { Start-Service MySQL -ErrorAction SilentlyContinue }

# Demarrer serveur (sans attendre)
Start-Job -ScriptBlock { Set-Location "C:\Users\hp\Documents\cica"; php artisan serve --quiet } | Out-Null

# Attendre 3 secondes et ouvrir
Start-Sleep 3
Start-Process $serverUrl

# Interface ultra-minimaliste
$Host.UI.RawUI.WindowTitle = "Laravel CICA - ACTIF"
Clear-Host
Write-Host "✅ LARAVEL CICA ACTIF - $serverUrl" -ForegroundColor Green
Write-Host "❌ Fermez pour arreter" -ForegroundColor Red
Write-Host ""

# Attendre indefiniment
try {
    do { Start-Sleep 60 } while ($true)
} catch { }
