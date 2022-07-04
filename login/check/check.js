export function checkWorthOfInput(thatInp, inpValue)
{
    switch(thatInp)
    {
        case "login": return inpValue.length >= 4 && inpValue.length <= 22;
        case "password": return inpValue.length >= 7 && inpValue.length <= 30;
    }
}