# Tehvan Marjapuu

# Jätkame ülesanne 17 ja 18 kasutatud andmebaasiga.
# Kursuste andmebaas
# Spordiklubi andmebaas
# Raamatukogu andmebaas
# Majutuse andmebaas
# Loo oma andmebaasile graafiline liides andmete lisamiseks.
# Muuda välja kohustuslikuks ja loo vastav teade
# Loo teatekast, mis teavitab edukast või ebaõnnestunud lisamisest

import sqlite3
import tkinter as tk
from tkinter import messagebox

# kontroll
def kontrolli():
    if not kastid["eesnimi"].get():
        messagebox.showerror("Viga", "Eesnimi on kohustuslik!")
        return False
    if not kastid["perenimi"].get():
        messagebox.showerror("Viga", "Perenimi on kohustuslik!")
        return False
    if not kastid["email"].get():
        messagebox.showerror("Viga", "Email on kohustuslik!")
        return False
    if not kastid["tel"].get().isdigit():
        messagebox.showerror("Viga", "Telefon peab olema number!")
        return False
    if not kastid["profiilipilt"].get():
        messagebox.showerror("Viga", "Profiilipilt on kohustuslik!")
        return False
    return True

# Funktsioon lisab andmed andmebaasi
def lisa_andmed():
    if kontrolli():
        try:
            andmebaas = sqlite3.connect("tmarjapuu.db")
            cur = andmebaas.cursor()

            cur.execute("""
                INSERT INTO users (eesnimi, perenimi, email, tel, profiilipilt)
                VALUES (?, ?, ?, ?, ?)
            """, (
                kastid["eesnimi"].get(),
                kastid["perenimi"].get(),
                kastid["email"].get(),
                kastid["tel"].get(),
                kastid["profiilipilt"].get()
            ))

            andmebaas.commit()
            messagebox.showinfo("Edu", "Andmed lisatud!")

            # Tühjenda kastid
            for kast in kastid.values():
                kast.delete(0, tk.END)

        except:
            messagebox.showerror("Viga", "Midagi läks valesti!")
        finally:
            andmebaas.close()

# Tee aken
aken = tk.Tk()
aken.title("Lihtne andmesisestus")

# Siltide ja kastide tegemine
kastid = {}
nimed = ["eesnimi", "perenimi", "email", "tel", "profiilipilt"]

for jrk, nimi in enumerate(nimed):
    tk.Label(aken, text=nimi).grid(row=jrk, column=0, padx=10, pady=5)
    kast = tk.Entry(aken, width=30)
    kast.grid(row=jrk, column=1, padx=10, pady=5)
    kastid[nimi] = kast

# Nupp
tk.Button(aken, text="Lisa", command=lisa_andmed).grid(row=len(nimed), column=0, columnspan=2, pady=15)

# Käivita
aken.mainloop()