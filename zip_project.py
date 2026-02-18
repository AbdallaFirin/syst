
import os
import zipfile

def zip_project(output_filename):
    exclude_dirs = {'node_modules', '.git', '.idea', '.vscode', '__pycache__'}
    exclude_files = {'.env', '.DS_Store', 'Thumbs.db', 'zip_project.py', output_filename}
    
    with zipfile.ZipFile(output_filename, 'w', zipfile.ZIP_DEFLATED) as zipf:
        for root, dirs, files in os.walk('.'):
            # Remove excluded directories from traversal
            dirs[:] = [d for d in dirs if d not in exclude_dirs]
            
            # Handle public/storage specific exclusion
            # root logic: Normalize path separators to avoid OS issues
            rel_root = os.path.relpath(root, '.')
            path_parts = rel_root.split(os.sep)
            
            # If we are in 'public' directory, remove 'storage' from dirs to visit
            if path_parts[-1] == 'public':
                if 'storage' in dirs:
                    dirs.remove('storage')

            for file in files:
                if file in exclude_files:
                    continue
                
                file_path = os.path.join(root, file)
                arcname = os.path.relpath(file_path, '.')
                zipf.write(file_path, arcname)
    
    print(f"Successfully created {output_filename}")

if __name__ == '__main__':
    zip_project('Firesfty_Production.zip')
