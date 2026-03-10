# deploy.ps1
# Automates: git add -> git commit -> git push -> SSH Trigger Coolify Deploy

param (
    [string]$Message = "Auto-deploy: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"
)

# 1. Push to GitHub
Write-Host "`n[GIT] Pushing code to GitHub..." -ForegroundColor Cyan
git add .
# Check if there are changes to commit
$changes = git status --porcelain
if ($changes) {
    git commit -m $Message
    git push origin (git branch --show-current)
}
else {
    Write-Host "No changes to commit, checking remote status..." -ForegroundColor Yellow
    git push origin (git branch --show-current)
}

# 2. Trigger Coolify via SSH (Bypassing Cloudflare)
# This hits the Coolify internal API directly on the VPS
Write-Host "[VPS] Triggering deployment (Bypassing Cloudflare)..." -ForegroundColor Cyan

# We use 'docker exec coolify' to hit the API from INSIDE the container network
# Using 'sh' instead of 'bash' because the alpine-based coolify container may not have bash
# We use 'docker exec coolify' to trigger the deployment action directly via PHP
# This bypasses API authentication and ensures the deployment is managed correctly by Coolify
ssh root@69.10.53.215 "docker exec -i coolify php -r 'include \"vendor/autoload.php\"; \$app = require_once \"bootstrap/app.php\"; \$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); \$app->make(App\Actions\Application\DeployApplication::class)->run(App\Models\Application::where(\"uuid\", \"zggs840sw8cw8g400cs80os0\")->first(), \"\");'"

Write-Host "`n[DONE] Deployment process started! Check your dashboard at https://coolify1.dragena.com" -ForegroundColor Green
