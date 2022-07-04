//poberamy wartości elementów input
export function getData(login, password, r_password)
{
    const loginValue = login.value;
    const passwordValue = password.value;
    const r_passwordValue = r_password.value;

    return {loginValue, passwordValue, r_passwordValue};
}