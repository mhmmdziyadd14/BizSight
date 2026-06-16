import sys
import codecs
try:
    import PyPDF2
    with open('Product_Mapping_Automation_System_Explanation.pdf', 'rb') as f:
        reader = PyPDF2.PdfReader(f)
        text = ""
        for page in reader.pages:
            text += page.extract_text()
        with codecs.open('scratch/pdf_text.txt', 'w', encoding='utf-8') as out:
            out.write(text)
except ImportError:
    pass
