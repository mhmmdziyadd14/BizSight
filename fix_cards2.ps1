$f = 'd:\bisnis\business-checker\resources\views\welcome.blade.php'
$c = [System.IO.File]::ReadAllText($f)

# Fix duplicate dark class on bundle tier1
$c = $c -replace 'class="bg-white dark:bg-white dark:bg-white/5 border border-gray-200 dark:border-gray-200 dark:border-white/10 p-8 rounded-3xl flex flex-col relative group hover:border-orange-500/50 transition-all"', 'class="light-card p-8 rounded-3xl flex flex-col relative group"'

# Fix bundle tier2
$c = $c -replace 'class="bg-white dark:bg-white dark:bg-white/5 border border-orange-500/30 p-8 rounded-3xl flex flex-col relative group shadow-\[0_0_40px_rgba\(249,115,22,0\.1\)\] hover:border-orange-500/60 transition-all"', 'class="light-card border-orange-400/50 dark:border-orange-500/40 p-8 rounded-3xl flex flex-col relative group shadow-[0_0_40px_rgba(249,115,22,0.15)]"'

[System.IO.File]::WriteAllText($f, $c)
Write-Host "Done!"
