
def check_div_balance(file_path):
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    import re
    # Remove comments
    content = re.sub(r'{{--.*?--}}', '', content, flags=re.DOTALL)
    content = re.sub(r'<!--.*?-->', '', content, flags=re.DOTALL)
    
    # Find all <div and </div
    open_divs = re.findall(r'<div\b', content)
    close_divs = re.findall(r'</div\b', content)
    
    print(f"Open divs: {len(open_divs)}")
    print(f"Close divs: {len(close_divs)}")
    
    # Trace them
    stack = []
    lines = content.split('\n')
    for i, line in enumerate(lines):
        tokens = re.findall(r'<(/?div)\b', line)
        for token in tokens:
            if token == 'div':
                stack.append(i + 1)
            else:
                if stack:
                    stack.pop()
                else:
                    print(f"Extra closing div on line {i + 1}")
    
    if stack:
        print(f"Unclosed divs starting on lines: {stack}")

check_div_balance('d:/bisnis/business-checker/resources/views/business/index.blade.php')
