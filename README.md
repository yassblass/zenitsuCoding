# zenitsuCoding
This is where all the magic happens.
=======
# Programming Project II | Group 6 | EhB Secretary Web Application
 
### Contributors
Souheib Touri, Yassine Tanouti, Adil El Ghamarti, Nouhayla Amenchar and Elyas Hamich from **Erasmus Hogeschool Brussels (EhB)**
 
### Our web application
Our project consists of a Web Application meant to make and manage appointments request in a school environment. At one side we have students who can make appointments, on the other side we have the secretaries who manages those appointments. 

### Motive
There is no hesitation in saying that the secretariat is very important in a school environment, that is why the communication should be flawless. In reality it is sometimes difficult to reach them. They may be busy with someone else, in a meeting or just not open. After some talking between our teammates we realized that it was a common problem. We have experienced such situations ourselves and sometimes it had annoying consequences. Some teachers even said that they were having difficulties too, so why not get started and develop a solution?

### Technologies used in this project
* Acces user-side through a **QR-code**
* **Vue.js** for the front-end
* **Laravel** for the back-end
* **Docker**

### Docker 
You can access our web application via this link : https://10.3.50.14/ (Make sure the school VPN is on) 
* See "Sprint Retrospective" in deliverables folder to understand Docker problems

### Launch our Web Application on your localhost
* `composer install` => Downloads all the libraries and dependencies for composer
* `npm install` => Downloads a package and it's dependencies
* `cp .env.example .env` => Add an .env file and edit it with your information
  * `php artisan key:generate`
* `php artisan migrate` => Commits all the needed tables in your database
* `npm run watch`=> Combines all your Vue components and other JavaScript files into a browser-friendly combined file
* `php artisan serve` => Launch local server
>>>>>>> 2aead1145f27f870f9354dbdcb51e6df80ea21e6
