export class ValidPasswordData 
{
    passwordSettings = {minLen: 7, maxLen: 30};

    validResult(newPassword, repeatPassword)
    {
        if(newPassword.length < this.passwordSettings.minLen || newPassword.length > this.passwordSettings.maxLen) return false;
        if(newPassword !== repeatPassword) return false;
    
        return true;
    }
}