import sys

file_path = r"e:\FREELANCE\recordingmanagementsystem\resources\views\livewire\student\profile.blade.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

content = content.replace("-blue-", "-red-")
content = content.replace("-indigo-", "-red-")

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Colors swapped successfully.")
