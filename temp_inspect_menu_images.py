import os, sqlite3
root = os.path.abspath(os.path.dirname(__file__))
print('PWD', root)
print('DB exists', os.path.exists(os.path.join(root, 'database', 'database.sqlite')))
if os.path.exists(os.path.join(root, 'database', 'database.sqlite')):
    conn = sqlite3.connect(os.path.join(root, 'database', 'database.sqlite'))
    cur = conn.cursor()
    cur.execute('SELECT id,name,image FROM menus')
    rows = cur.fetchall()
    print('rows', len(rows))
    for r in rows:
        print(r)
    conn.close()
print('storage dir exists', os.path.exists(os.path.join(root, 'storage', 'app', 'public', 'menus')))
if os.path.exists(os.path.join(root, 'storage', 'app', 'public', 'menus')):
    print('storage files', os.listdir(os.path.join(root, 'storage', 'app', 'public', 'menus')))
print('public storage exists', os.path.exists(os.path.join(root, 'public', 'storage')))
if os.path.exists(os.path.join(root, 'public', 'storage')):
    try:
        print('public storage files', os.listdir(os.path.join(root, 'public', 'storage'))[:20])
    except Exception as e:
        print('PUBLIC_STORAGE_ERR', e)
