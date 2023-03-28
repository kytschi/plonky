# Plonky
PHP module RESTful app written in zephir-lang

## What is plonky?
So as many of you have probs experienced, your happily using something like Postman and you upgrade it only to find your collections are now broken or the app won't start.

This happened to me...again...so I have moaning to my cousin and he said, "Why not build your own? Been thinking about doing one myself" so he challenged me to a "dev-off" where we'd each take a few months and build out own app.

Originally it was to be built in Python using kivy and kivyMD as I wanted to get to know kivy. Sorry kivy team and devs but the experience was a painful one! The amount of headaches I had just getting stuff to build, position correctly and stay stable was too much my hair-line could take. So after about 3 weeks or so of on and off dev I threw in the towel.

I'd been toying with the idea (after a dream I had) with making an app in Zephir-lang as I use it for my kytschBASIC language (https://kytschbasic.org) and I just love it! So I figured I'd see if you could make a pure HTML, CSS and JS app that'll run as a PHP module.

And this is what come of it.

### Please note
This is more of a tech demo than an actual functional app. That doesn't mean it can't be used as such but its just a tool for me to play around with.

## For mam, the OG plonky...
                                                                                                    
                                                 .                                                  
                                          .,;cokOkddooocccc.                                        
                                       ..;ldlcokxxxxxxxdodool:'.                                    
                                 ..''....';:lccooddooololl:;,'',c:'                                 
                               ...........,;;,;;;:;:,,;,;;;,'....c:;;,.                             
                             ...    .......'......... ....,;'.. ..',,d0l                            
                           ...       ...',...            ............'::.                           
                      .....          ......                 ......'.......                          
                      ...     . .........                     .........  ';.                        
                               ........     ..                ............:o,..                     
                        ....      ........           .        ..',,;,,..........'                   
                 .    ......       ...'...         .            ..''......   .....                  
               ... ..'.......      ........        ...      .. . ...,,..      .....                 
             ...... ...   ...  ....'''....'...........   ...........,......     ...                 
            ..      ...   .............';:::lc;cl:;:;...',:,'.......',,',,'..   ...                 
                   .     ........,,.,,:loccddlxklodxc..:lollo;,,;'',.........     ..                
                          ....''';;,;;lxdcodxoxddkkkc';dxdodd:,;;'''......   .......                
    .                     .'..'',,;:c:dxdllxkxdddkOOo:lxkkOOOxc;:;'........    ....''               
                         .,,''...';ooooxxoloxddxdkOOklcdkkO00Oxlc;;;::c:,...     ...'.              
          ..    ..      .;c:c:'.:ldkxddxkkxdooxxooxOOOo:ldxkOOOkc;,,;lc;,'...   .......             
   ..     ..    ..     .;lddoooxOOO00OkkO00KK00000OOO00koccloolcdd:,',:,;'............':.           
   ...   .     ..     .'cdxxxkOOOO0000KKKKKKXXXKXXXKKKK00OkkkkOO00Odl;,;;,.............cc           
    ..         ...    .;ldxxkOOOO0000KKKKKKXXXXKKXXXXKKKKKKKKKKKKK000OOkxdc,.. .......':l.          
    .... .    ....   .,codddxxkkO0000KKKKXXXXXXKKXXXXXXXXKKKKKKKK00000OOOxl,.  ...........          
   .....        ... .':cllcclodxxxkOO0KKKXXXXXXXXXXXXXXXXKKKKKK0K00000OOOkd;..............          
  .'...      ....   .;cc:codxxxxxdollodxk00KKKKKKXXXKKKKKK0000000OOO00OOOOxc..............          
  ...      ......   .:cc:ldxkOO00000OkkkkkO0KKKKKKKK000OOkxxddddxkxxddxkOOkd;.,.... .......         
 ..      .......   .,coo:coddoc:;:loxk0000OO0KKKKKKK0000OOkkO000000Okkxdxkkxo,....  ....'..         
..      .......   .':lxxd:;..;ol'.,cddxkO0OkO0KKKKK0000000OkxxkkO0000OOkxkkxx:.....    ..'...       
.       .......   .';oxkxo:;:codolokOOOO00OkkO0KK0000K0Oxxxd:',,:lldkOkxkkkkx:.......   ..'.''.     
           ...   ...,odxxodxxxxxkOOOO0000OOkxO0000000KKOkkkOdccokx:,:dxkOOOkxc......   ....',;;.    
           .'..   ..,odxddxkkkkOO0000000OOOxxO000OO000000OOOOOkxxxdddxkO0Okxd:.. ...    .....,;'    
          ..... . . ,odddxxkkkOOO000000OOkxxkO000OOO000KK000000OOOOOOOOOOkxdo:...............'''    
        ...... ..  .;oddxxkkkO000KKKKK00OxxkkO00OOOO000KKKKKKK00OOOOOOOOOkxol;...............,,.    
       ...      .  .:oddxkkOO00KKKKKKK0kkdxkOOOOOOOOO0KKKKKKKKKK0OOOOOOOkkdol,....... .......'      
         ..   ...  .:lodxkkOO00KKKK000kxxdxkO000OOOOOO0KKKKKKKKKK00OOOOOkxool'............';,.      
    .        ....  .:lodxkkOO000000000Oooodk0KKKOOOOOkOOO00KKXKKK000OOOkxdool'............,,'.      
             ..c:. .;codxxkkOOO00000K00OkdllodxkxxkkkO000OO00K000000OOkkxdooo,..'....'......:.      
              .:'  .;loodxxkkkOOO0000000000OOOO0000000KKKK0OO0000OOOOOkxxdooc:'.'...... ....:       
               ...  'loddxkkOOOkkkkOOkkkkOO00K00K00000000000OOOOOOOOkkxxdoooo:'............'.       
                    .coddxkkO0000OxllddddoooodxxxxxkkkOOOOOOOOkkOOOkkkkxdol:... ....  ...''         
            ....    .:oddxxkO0000OkxoddkOO000OOOOxOkkxkxddkkOOO000OOkkkxdl;...   .... ..';.         
           ..        'lodxxkOO0OOOOOkxdooodxkkkOkkkxxdddkO000O0000OOOkkxo:;cc....  .....''.         
          ....        ;lodxxkO0OOkkOOOOOkkxkkO00OkxxxkOO0O000000OOOOOkkd; ........   ...,coo.       
           ...        .;lodxkkOkkOOOOOOO00000000000000000OOO0000OOOOkkd;   ..   ..........';.       
     .                  'lddxxkxxkkOOOOO0000000KKKK000000OO0000OOOkkxd:     .    ...';;'....        
  ..                     .:odddddxkkkkkOOOO00000000000000OO0000OOkkxo;      .  ......'......        
                          .'clooloxkkkkkOOO00000OOOOOO00OOOOOOOOkxdoc. ..  .    ..'',.......        
           .       .     ....,:ccccdxkkkkO0000KK0OOOOOOOOkkkOOkxdool:''......    .....    .''       
                        .coc,..';::;:oxxkkOOOOOOOOOOOOkxddxxxdollool:;c. ....            . .ll      
                       'cddxxdl;.';::;:ccldxkOkkkkkxxdddddoollodddolc:c.    ..               .      
                       ,odxxkkkkdc,',;cloooooooddddddddolllodxxxxxxxoc.                             
                       .odxkkkkOkkxc'',;clooddddddooolllodxxkkkkkkkkx. ..                           