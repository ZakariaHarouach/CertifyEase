function GetGroups(level){
      let groupes={
        "dev":{
            "1a":["DEV101","DEV102","DEV103","DEV104","DEV105","DEV106","DEV107","DEV108","DEV109","DEV110","DEV111","DEV112","DEV113","DEV114","DEV115"],
            "2a":["DEVOWFS201","DEVOWFS202","DEVOWFS203","DEVOWFS204","DEVOWFS205","DEVOWFS206","DEVOWFS207","DEVOWFS208","DEVOWFS209","DEVOWFS210"]
        }
    }
    
    let ToLoop;

     switch(level){
        case "1a":
            ToLoop=groupes.dev["1a"]
            break;
        case "2a":
            ToLoop=groupes.dev["2a"];
            break;
        default:
            alert("You have to pick a choice");
            break;
        }

        return ToLoop;
}

function AddGroups(){

    let Groups=document.getElementById("gourp");
    Groups.innerHTML="";
    let level=document.getElementById("Level").value;

    let ToLoop=GetGroups(level);

    for(let GName of ToLoop){
        let G=document.createElement("option");
        G.value=GName;
        G.textContent=GName;
        Groups.appendChild(G);
    }
}