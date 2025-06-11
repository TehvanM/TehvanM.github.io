# Tehvan Marjapuu h19


import sqlite3
import tkinter as tk
from tkinter import messagebox


def validate_data():
    eesnimi_kt = entries["eesnimi"].get()
    perenimi_kt = entries["perenimi"].get()
    email_kt = entries["email"].get()
    tel_kt = entries["tel"].get()
    profiilipilt_kt = entries["profiilipilt"].get()

    if not eesnimi_kt:
        messagebox.showerror("Eesnimi on kohustuslik!")
        return False
    if not perenimi_kt:
        messagebox.showerror("Perenimi on kohustuslik!")
        return False
    if not email_kt:
        messagebox.showerror("Email on kohustuslik!")
        return False
    if not tel_kt.isdigit():
        messagebox.showerror("Telefoni number on kohustuslik ja sisaldama ainult numbreid!")
        return False
    if not profiilipilt_kt:
        messagebox.showerror("Profiilipilt on kohustuslik!")
        return False

    return True

#andmebaasiga yhenduse loomine

def insert_data():
    if validate_data():
        try:


            connection = sqlite3.connect("h161.db")
            cursor = connection.cursor()
            print("yhendus loodud")

            cursor.execute("""
                INSERT INTO users (eesnimi, perenimi, email, tel, profiilipilt)
                VALUES (?, ?, ?, ?, ?)
            """, (
                entries["eesnimi"].get(),
                entries["perenimi"].get(),
                entries["email"].get(),
                entries["tel"].get(),
                entries["profiilipilt"].get()
            ))


        except sqlite3.Error as error:
            print("viga andmebaasiga ühendamisel:", error)


        finally:
            if connection:
                connection.commit()
                connection.close()
                clear_entries()
                print("yhendus suletud")
                messagebox.showinfo("Andmed sisestati edukalt!")



def clear_entries():
    for entry in entries.values():
        entry.delete(0, tk.END)



root = tk.Tk()
root.title("andmete sissestamine")

# Loo sildid 
labels = ["eesnimi", "perenimi", "email", "tel", "profiilipilt"]
entries = {}

for i, label in enumerate(labels):
    tk.Label(root, text=label).grid(row=i, column=0, padx=10, pady=5)
    entry = tk.Entry(root, width=40)
    entry.grid(row=i, column=1, padx=10, pady=5)
    entries[label] = entry

# lloo nupp
submit_button = tk.Button(root, text="Sisesta andmed", command=insert_data)
submit_button.grid(row=len(labels), column=0, columnspan=2, pady=20)

# tkinteri akent
root.mainloop()