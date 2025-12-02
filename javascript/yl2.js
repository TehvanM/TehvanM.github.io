//Tehvan Marjapuu
//IT-23
//17.11.25

// YL 1 

let esimene = 4.2;
let teine = "Will Code 4 food"
let kolmas = "123";
let neljas = [1,2,3]
let kuues = false;
let seitsmes = "true";
let kaheksas = undefined;

console.log(typeof esimene, typeof teine, typeof kolmas);
console.log(typeof neljas, typeof viies, typeof kuues);
console.log(typeof seitsmes, typeof kaheksas );


// YL 2
// 02.12.25

let tunnid
let minutid
let sekundid

tunnid = 14
minutid = 34
sekundid = 42

console.log("Kell on " + tunnid + ":" + minutid + ":" + sekundid + "PM");


let lorem = "/Lorem ipsum dolor sit amet, consectetur adipiscing elit./"
let vidu = lorem + " - De finibus bonorum "
console.log(vidu);

let eesnimi = "Tehvan"  
let perenimi = "Marjapuu"

let esi = eesnimi[0]
let tei = perenimi[0]

console.log(`${eesnimi} ${perenimi} nimetähed on ${esi}.${tei}.`);

let nimiterve = "Tehvan Marjapuu"
let koma = nimiterve.indexOf(",")
let perenimik = nimiterve.slice(koma + 8)
let nimipikkus = perenimik.length

console.log(`Perekonnanimi on ${perenimik} ja selle pikkus on ${nimipikkus} sümbolit.`);

let epost = "kaasdrrolk@netlasdog.com";
let dom = "gamil"
let atindex = epost.indexOf("@")
let punktindex = epost.indexOf(".")
let kasutajanimi = epost.substring(0, atindex)
let lopp = epost.substring(punktindex)
let uuspost = `${kasutajanimi}@${dom}${lopp}`;
console.log(uuspost);

let rida = "1,Marshal,Martinovic,mmartinovic0@dedecms.com,Male,40.19.226.175"
let andmed = rida.split(",")
let email = andmed[3]
let ip = andmed[andmed.length - 1]
let kasutajanimi2 = email.substring(0, email.indexOf("@"))

console.log(`Kasutajanimi on ${kasutajanimi2} ja IP aadress on ${ip}.`);

// YL 3
// 02.12.25

// Sõidu aeg ja kaugus
// Õpilane tahab teada, kui kaua võtab aega teatud kauguse läbimine kindla kiirusega. 
// Kasuta muutujaid sõidu kauguse (kilomeetrites) ja kiiruse (kilomeetrites tunnis) hoidmiseks. 
// Arvuta ja kuva konsooli sõidu aeg (tundides).

let kiirus = 100 // km/h
let kaugus = prompt("Sisesta sõidu kaugus kilomeetrites:") // km

let aeg = kaugus / kiirus // h
let tunnid1 = Math.floor(aeg);                    // täistunnid
let minutid1 = Math.floor((aeg % 1) * 60);        // ülejäänud minutid
let sekundid1 = Math.floor((((aeg % 1) * 60) % 1) * 60); // ülejäänud sekundid

console.log(`Sõidu aeg on ${tunnid1} tundi ${minutid1} minutit ${sekundid1} sekundit.`);

// Postituste kuvamine
// Andmebaasis on 137 postitust ning soovime neid kuvada veebilehel.
// Iga lehekülg kuvab maksimaalselt 10 postitust. 
// Sinu ülesanne on arvutada, mitu lehekülge on vaja postituste kuvamiseks ning mitu postitust on viimasel lehel.

let postitused = 137
let postitusedLehel = 10

let leheküljed = Math.ceil(postitused / postitusedLehel)
let viimaseLehePostitused = postitused % postitusedLehel || postitusedLehel

console.log(`Postituste kuvamiseks on vaja ${leheküljed} lehekülge. Viimasel lehel on ${viimaseLehePostitused} postitust.`);

// Serveri töökulu
// Sinu ülesanne on arvutada, kui palju maksab serveri töös hoidmine ühe tunni jooksul, kasutades järgmisi andmeid:
// Serveri võimsus: 400 vatti (W)
// Elektri hind: 9.69 senti/kWh
// Sinu ülesanne on arvutada serveri töökulu ühe tunni jooksul eurodes. Selleks peate järgima järgmisi samme:
// Arvuta serveri voolutarbimine kilovatt-tundides (kWh) kasutades järgmist valem:
// Voolutarbimine (kWh) = Võimsus (W) / 1000
// Arvuta töökulu, korrutades serveri voolutarbimise elektri hinnaga:
// Töökulu (eurodes) = Voolutarbimine (kWh) * Elektri hind (eurod/kWh)
// Oma vastuses anna teada, kui palju maksab serveri töös hoidmine ühe tunni jooksul eurodes.

let voimsus = 400 // W
let elektriHind = 9.69 / 100 // eurod/kWh
let voolutarbimine = voimsus / 1000 // kWh
let töökulu = voolutarbimine * elektriHind // eurodes
console.log(`Serveri töökulu ühe tunni jooksul on ${töökulu.toFixed(4)} eurot.`);

// YL 4


