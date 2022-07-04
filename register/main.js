
import { Listener } from "../register/listener/listener.js";

class InitInputes
{

    listener = new Listener();

    constructor()
    {
        this.init();
    }

    // metoda dzięki której pobieramy elementy input w klasie Listener
    init()
    {
        this.listener.addInputListener();
    }

}

//  tworzymy instancje klasy w której pobierzemy elementy input z naszej rejestracji
const initInputes = new InitInputes();