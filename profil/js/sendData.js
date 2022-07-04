import { serviceResponse } from "./servResponse.js";

export function updateProfilPhoto(file)
{

 let xhr = new XMLHttpRequest();

 xhr.onload = () => {
    if(xhr.status === 200)
    {
       if(xhr.readyState === 4)
       {
         const response = JSON.parse(xhr.response);
         if(response.change){
            
            xhr.onload = () => {
               if(xhr.status === 200)
               {
                  if(xhr.readyState === 4)
                  {
                    const img = document.getElementById("profil").querySelector("img");
                    img.src = `data:image/png;base64,${xhr.response}`;
                  };
               };
            };
            xhr.open("GET", "../profil/php/showProfilPhoto.php", true);
            xhr.send();
         }
       };
    };
 };

 const photo = new FormData();
 photo.append("photo", file)
 
 xhr.open("POST", "../profil/php/updateProfilPhoto.php", true);
 xhr.send(photo);
}

export function SendData()
{

   this.send = function(data)
   {
      const xhr = new XMLHttpRequest();

      xhr.onload = () => {
         if(xhr.status === 200)
         {
            if(xhr.readyState === 4)
            {
               const res = JSON.parse(xhr.response);
               if(res.email_changed)
               {
                  alert("Zweryfikuj swój email!");
               }
            };
         };
      };

      xhr.open("POST", data.url, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send(data.so+"="+data.value);
   }
   
};