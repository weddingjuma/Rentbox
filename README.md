# Tietokantasovelluksen esittelysivu

Yleisiä linkkejä:
* [Linkki sovellukseeni](http://jussivii.users.cs.helsinki.fi/tsoha/)
  * Käyttäjätunnus: vuokra.loordi@gmail.com
  * Salasana: salaissana
* [Linkki dokumentaatiooni](https://github.com/eeaa/Tsoha-Bootstrap/blob/master/doc/dokumentaatio.pdf)

Käyttöliittymän staattiset sivut:
* [Kirjautumissivu](http://jussivii.users.cs.helsinki.fi/tsoha/)
* [Hakutulosten listaus](http://jussivii.users.cs.helsinki.fi/tsoha/search)
* [Käyttäjän oma portfolio](http://jussivii.users.cs.helsinki.fi/tsoha/user/portfolio)
* [Käyttäjän oman vuokrakohteen esittelysivu](http://jussivii.users.cs.helsinki.fi/tsoha/user/unit)
* (Jos vuokrakohde ei ole oma näytetään vain sivun yläosa; kohteeseen liittyvät vuokrasopimukset ovat vain kohteen omistajan nähtävissä)
* [Kohteen julkisten tietojen muokkaussivu / Kohteen lisäämissivu](http://jussivii.users.cs.helsinki.fi/tsoha/user/unit/edit)
* [Kohteeseen liittyvän vuokrasopimuksen muokkaus / lisäyssivu](http://jussivii.users.cs.helsinki.fi/tsoha/user/unit/lease)

## Työn aihe

Järjestelmällä hallitaan vuokra-asuntoportfoliota. 
Järjestelmään rekisteröitynyt käyttäjä voi lisätä portfolioonsa vuokrakohteita. 
Vuokrakohteisiin voi lisätä valokuvia ja vuokrasopimuksia. 
Vuokrasopimukseen sisältyy hinta, sopimuksen alkamis- ja loppumispäivät, sekä 
vuokrattavan kohteen lisäksi hintaan kuuluvat muut hyödykkeet (sähkö, vesi, jne). 

Rekisteröitynyt käyttäjä voi myös hakea julkiset tiedot kaikkien käyttäjien palveluun
listaamista vuokrakohteista.

Työ toteutetaan PHP:llä. Tietokantapalvelimena käytetään PostgreSQL:ää. Työ pystytetään users-palvelimelle.

 
