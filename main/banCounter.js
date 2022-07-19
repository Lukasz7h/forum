let spanTime;

export function addSpan()
{
    const spanBan = document.createElement("span");
    spanBan.classList.add("ban_time");

    document.body.insertAdjacentElement("afterbegin", spanBan);

    spanTime = document.body.querySelector(".ban_time");
}

function endBan()
{
    const spanBan = document.body.querySelector(".ban_time").remove();
    alert("Możesz ponownie komentować");
}

function banIsOver()
{
    const xhr = new XMLHttpRequest();
   
    return new Promise((resolve, reject) => {
        xhr.onload = () => {
            if(xhr.status === 200)
            {
                if(xhr.readyState === 4)
                {
                    const res = JSON.parse(xhr.response);

                    if(!res.ban) endBan();
                    return resolve(res.ban);
                };
            };
        };
    
        xhr.open("GET", "../detail/php/comment/banIsOver.php?ban=true", true);
        xhr.send();
    });
}

let banTime;
export function banCounter(_banTime, _currentTime)
{
    if(_banTime && _currentTime)
    {
        banTime = _banTime;
    };

    const currentTime = new Date();
    const dateDiff = Math.abs(banTime - currentTime);

    const hours = Math.floor((dateDiff / 1000 / 60 / 60) % 60);
    const minutes = Math.floor(((dateDiff / 1000) / 60) % 60);
    const seconds = Math.floor((dateDiff / 1000) % 60);

    spanTime.textContent = `Pozostały czas bana: ${hours} godzin,
    ${minutes < 10? "0"+minutes: minutes} minut,
    ${seconds < 10? "0"+seconds: seconds} sekund`;

    const banInterval = setTimeout(async () => {
        if(hours <= 0 && minutes <= 0 && seconds <= 0)
        {
            const banDone = await banIsOver();
            if(banDone) clearTimeout(banInterval);
        }
        else{
            banCounter();
        };
    }, 1000);

    
}