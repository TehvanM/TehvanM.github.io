# Tehvan Marjapuu h20


import tkinter as tk
from tkinter import ttk
import sqlite3
import subprocess

#Funktsioon, mis laadib andmed SQLite andmebaasist ja sisestab need Treeview tabelisse
def load_data_from_db(tree, search_query=""):
    for item in tree.get_children():
        tree.delete(item)
    # Loo ühendus SQLite andmebaasiga
    conn = sqlite3.connect('.\tmarjapuu.db')
    cursor = conn.cursor()

    # Tee päring andmebaasist andmete toomiseks
    if search_query:
        cursor.execute("SELECT id, eesnimi, perenimi, email, tel, profiilipilt FROM users WHERE eesnimi LIKE ?", ('%' + search_query + '%',))
    else:
        cursor.execute("SELECT id, eesnimi, perenimi, email, tel, profiilipilt FROM users")

    rows = cursor.fetchall()


    # Lisa andmed tabelisse
    for row in rows:
        tree.insert("", "end", values=row)

    # Sulge ühendus andmebaasiga
    conn.close()



def on_search():
    search_query = search_entry.get()
    load_data_from_db(tree, search_query)



def add_data():
    subprocess.run(["python", ".\h19\h19.py"])


root = tk.Tk()
root.title("Kasutaja andmete kuvamine")


search_frame = tk.Frame(root)
search_frame.pack(pady=10)

search_label = tk.Label(search_frame, text="Otsi eesnime järgi:")
search_label.pack(side=tk.LEFT)

search_entry = tk.Entry(search_frame)
search_entry.pack(side=tk.LEFT, padx=10)

search_button = tk.Button(search_frame, text="Otsi", command=on_search)
search_button.pack(side=tk.LEFT)


# avab h19.py
open_button = tk.Button(root, text="Lisa andmeid", command=add_data)
open_button.pack(pady=20)


# Loo raam kerimisribaga
frame = tk.Frame(root)
frame.pack(pady=20, fill=tk.BOTH, expand=True)
scrollbar = tk.Scrollbar(frame)
scrollbar.pack(side=tk.RIGHT, fill=tk.Y)

# Loo tabel (Treeview) andmete kuvamiseks
tree = ttk.Treeview(frame, yscrollcommand=scrollbar.set, columns=("id","eesnimi", "perenimi", "email", "tel", "profiilipilt"), show="headings")
tree.pack(fill=tk.BOTH, expand=True)

# Seosta kerimisriba tabeliga
scrollbar.config(command=tree.yview)

# Määra veergude pealkirjad ja laius
tree.heading("id", text="id")
tree.heading("eesnimi", text="eesnimi")
tree.heading("perenimi", text="perenimi")
tree.heading("email", text="email")
tree.heading("tel", text="tel")
tree.heading("profiilipilt", text="profiilipilt")

tree.column("id", width=150)
tree.column("eesnimi", width=100)
tree.column("perenimi", width=60)
tree.column("email", width=100)
tree.column("tel", width=60)
tree.column("profiilipilt", width=60)


# Lisa andmed tabelisse
load_data_from_db(tree)

root.mainloop()