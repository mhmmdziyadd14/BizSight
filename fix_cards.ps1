$f = 'd:\bisnis\business-checker\resources\views\welcome.blade.php'
$c = [System.IO.File]::ReadAllText($f)

# Replace feature cards
$c = $c -replace 'feature-card bg-white dark:bg-white/10 border border-gray-200 dark:border-white/10', 'feature-card light-card'
$c = $c -replace 'feature-card bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10', 'feature-card light-card'

# Replace how-it-works cards
$c = $c -replace 'bg-white dark:bg-white/10 border border-gray-200 dark:border-white/10 p-8 rounded-3xl relative overflow-hidden group shadow-sm', 'light-card p-8 rounded-3xl relative overflow-hidden group'

# Replace testimonial cards
$c = $c -replace 'bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 p-8 rounded-3xl relative"', 'light-card p-8 rounded-3xl relative"'

# Replace bundle tier1 card
$c = $c -replace 'bg-white dark:bg-white/10 border border-gray-200 dark:border-white/10 p-8 rounded-3xl flex flex-col relative group hover:border-orange-500/50 transition-all', 'light-card p-8 rounded-3xl flex flex-col relative group'

# Replace bundle tier2 card  
$c = $c -replace 'bg-white dark:bg-white/5 border border-orange-500/30 p-8 rounded-3xl flex flex-col relative group shadow-\[0_0_40px_rgba\(249,115,22,0\.1\)\] hover:border-orange-500/60 transition-all', 'light-card border-orange-400/40 p-8 rounded-3xl flex flex-col relative group shadow-[0_0_40px_rgba(249,115,22,0.15)]'

# Replace info box
$c = $c -replace 'mt-12 bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl', 'mt-12 light-card rounded-xl'

[System.IO.File]::WriteAllText($f, $c)
Write-Host "Done!"
