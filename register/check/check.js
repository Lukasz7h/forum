import { ChangeStyle } from "../changeStyle/changeStyle.js";

export class Check extends ChangeStyle
{

    constructor(){
        super();
        if(Check.instance)
        {
            return Check.instance;
        };

        Check.instance = this;
    }

    //tu przechowujemy wartości naszych haseł
    passwordValue;
    r_passwordValue;

    //ustawienia naszych elementów input czyli ich nazwa oraz dozwolona minimalna i maksymalna długość wartości
    settings = [
        this.loginLen = {min: 4, max: 22},
        this.passLen = {min: 7, max: 30},

        {name: "login", settingsLen: this.loginLen},
        {name: "password", settingsLen: this.passLen},
        {name: "r_password", settingsLen: this.passLen}
    ]

    //sprawdzamy czy długość loginu lub hasła się zgadza i powiadamiamy o tym użytkownika przez elementy na stronie
    checkLength(inputName, value)
    {
        const valueLen = value.length;
        let flag;

        this.settings.filter(element => {

            if(element.name === inputName)
            {
                flag = valueLen >= element.settingsLen.min && valueLen <= element.settingsLen.max;
                this.changeStyle(flag, inputName);
            }
        })
        return flag;
    }

    //ustalamy wartość z elementu input "hasło" lub "powtórz hasło"
    setPasswordValue(inputName, value)
    {
        inputName === "password"? this.passwordValue = value: this.r_passwordValue = value;
        this.checkRepeatPassword();
    }

    //sprawdzamy czy podane hasła są takie same i powiadamiamy o tym użytkownika przez elementy na stronie
    checkRepeatPassword()
    {
        if(this.passwordValue === undefined || this.r_passwordValue === undefined) return false;

        if(this.checkLength("password", this.passwordValue) && this.checkLength("r_password" ,this.r_passwordValue))
        {
            this.password.value === this.r_password.value? 
            this.changeStyle(true, "r_password"):
            this.changeStyle(false, "r_password")

            return this.password.value === this.r_password.value;
        }

        return false;
    }
}