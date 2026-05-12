import json
import subprocess

result = subprocess.run(['php', 'artisan', 'route:list', '--json'], capture_output=True, text=True)
routes = json.loads(result.stdout)

for route in routes:
    if 'approved' in route['middleware']:
        print(f"Route: {route['uri']} ({route['name']}) has 'approved' middleware")
