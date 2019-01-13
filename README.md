ToDo

Instructions on Linux

These instructions were tested on Ubuntu 14.04 and 17.10 and Debian 9 and Fedora 27.
Create the firmware image

1) Install the required packages:
    Ubuntu: sudo apt-get install ccrypt git wget unzip
    Fedora: sudo dnf install ccrypt git wget unzip
    
2) Create a working directory: mkdir dc && cd dc
    
3) Download the dustcloud firmwarebuilder: wget https://github.com/dgiese/dustcloud/releases/download/0.1/firmwarebuilder_0.1.zip
   Unzip the file unzip firmwarebuilder_0.1.zip
   I downloaded the full repository instead and used it in the folder.
    
4) Download the firmware image and language data:
        Find the latest .pkg link from here: https://github.com/dgiese/dustcloud/wiki/Xiaomi-Vacuum-Firmware
        You need to select the correct model (Gen1 without wiping, just vacuum!)
        I used the latest 'rootable' firmware, in this case 3452

5) Copy your public SSH key to the working directory: cp ~/.ssh/id_rsa.pub .
        if you don't have SSH keys yet, refer to this guide https://help.github.com/articles/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent/#generating-a-new-ssh-key to create them.
        
        HowTo SSH Key
        
        Paste the text below, substituting in your GitHub email address.
        ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
        This creates a new ssh key, using the provided email as a label.
        Generating public/private rsa key pair.
        When you're prompted to "Enter a file in which to save the key," press Enter. This accepts the default file location.
        Enter a file in which to save the key (/home/you/.ssh/id_rsa): [Press enter]
        At the prompt, type a secure passphrase. For more information, see "Working with SSH key passphrases". 
        Enter passphrase (empty for no passphrase): [Type a passphrase]
        Enter same passphrase again: [Type passphrase again]

        Adding your SSH key to the ssh-agent
        Before adding a new SSH key to the ssh-agent to manage your keys, you should have checked for existing SSH keys and generated a new SSH key. 
        Start the ssh-agent in the background.
        eval "$(ssh-agent -s)"
        Agent pid 59566
        Add your SSH private key to the ssh-agent. If you created your key with a different name, or if you are adding an existing key that has a different name, replace id_rsa in the command with the name of your private key file.
        ssh-add ~/.ssh/id_rsa
         
6) Run the image builder: sudo ./dustcloud/devices/xiaomi.vacuum/firmwarebuilder/imagebuilder.sh -f v11_001228.pkg -k id_rsa.pub
   I added --disable-xiaomi
   
   After the build has succeeded, you are ready to upload the firmware to your vacuum.


Upload the firmware image

This assumes we are still in the working directory from the building step.

1) Install the required packages: sudo apt-get install python3 python3-pip python3-venv python3-dev
2) Create a virtual env for our python packages: python3 -m venv .venv
3) Enter the virtual env: . .venv/bin/activate
4) Install wheel so the other packages can be installed successfully: pip install wheel
5) Install python-miio for communicating with the vacuum: pip install python-miio
6) Now press the wifi button on your vacuum and join the wifi created by it ('roborock-vacuum-s5_XXXXXXXX' or similar).
7) Use the flasher script to upload the new firmware: python flasher.py -f output/v11_001228.pkg
   I had to disconnect from my network (cable), otherwise it didn't find the robot in the wifi.
8) The update takes several minutes. After the upload is complete, the robot explains that it is now going to install an upgrade and restarts when it is complete. Once the robot has successfully restarted, you can connect to it via SSH.


Setup of wifi

1) Inside the virtual environment I did:
   mirobo discover --handshake 1
   There I got its IP and Token and used it to configure-wifi
2) mirobo --ip 172.20.255.194 --token ffffffffffffffffffffffffffffffff configure-wifi
   It told me to added network name and passphrase and then it was rebooting into the home wifi
   Again disconnected from network (cable).
   

Setup Valentudo (webinterface to control ronot. It runs directly on the robot without cloud connection whatsoever.

1) download the latest valetudo binary from the releases page or build it from source.
2) scp it to /usr/local/bin/.
3) grab the valetudo.conf from the deployment folder put it inside /etc/init/.
4) run service valetudo start and you're good. Don't forget to chmod +x /usr/local/bin/valetudo the binary.


Connect to IP and there you go. 
Give robot a fixed IP through router menue and then it is ready to clean your apartment! Cats behold...





- - - - - -





Welcome to our repository for reverse engineering and rooting of the Xiaomi Smart Home Devices. We provide you methods how to root your device without opening it or breaking the warranty seal (on your own risk).

The documentation of the devices (photos, datasheets, uart logs, etc) was moved to a new repo [dustcloud-documentation](https://github.com/dgiese/dustcloud-documentation)

Please take a look at the Dustcloud Wiki, which also contains instructions on how to root and flash your device: (https://github.com/dgiese/dustcloud/wiki)

# Talks
The content of the presentation differs from event to event. If you want to get an overview of the topics I am talking about, you find the overview here: [Overview over all topics in presentations](http://dontvacuum.me/talks/topics.html)  
[Sep 2018] I was invited by [BeyondSecurity](https://www.beyondsecurity.com/) to give a talk at BeVX 2018 in Hong Kong: [BeVX 2018 slides](http://dontvacuum.me/talks/BeVX-2018/BeVX.html)  
[Aug 2018] I have given two talks at DEFCON26 (101-track and IoT-Village), both are recorded:  
"Having fun with IoT: Reverse Engineering and Hacking of Xiaomi IoT Devices": [DEFCON26 101-track Slides](https://dgiese.scripts.mit.edu/talks/DEFCON26/DEFCON26-Having_fun_with_IoT-Xiaomi.html)  
"How-to modify ARM Cortex-M based firmware: A step-by-step approach for Xiaomi devices": [DEFCON26 IoT Village Slides](https://dgiese.scripts.mit.edu/talks/DEFCON26-IoT-Village/DEFCON26-IoT-Village_How_to_Modify_Cortex_M_Firmware-Xiaomi.html)  

[Jul 2018] I was on tour in Taiwan@HITCON14 Community: [HITCON14 CMT slides](https://dgiese.scripts.mit.edu/talks/HITCON14CMT/hitcon14-iot-reveng-101-xiaomi.html)  
[Feb 2018] We had a talk at [Recon BRX 2018](https://recon.cx/2018/brussels/). The presentation can be found [here](https://dgiese.scripts.mit.edu/talks/Recon-BRX2018/recon_brx_2018.html)  
[Dec 2017] Our talk at 34C3: [Recording hosted at media.ccc.de]( https://media.ccc.de/v/34c3-9147-unleash_your_smart-home_devices_vacuum_cleaning_robot_hacking), [updated PDF](https://dgiese.scripts.mit.edu/talks/34c3-2017/34c3.html).  

# Recommended resources / links

Flole App: alternative way to control the vacuum robot, instead of Xiaomi's Mi Home App. Is able to control and root your vacuum cleaner. Enables the use of various speech packages.
https://xiaomi.flole.de/

Roboter-Forum.com: German speaking forum with a lot of information about all sorts of robots. Contains special subforums for Xiaomi rooting. Primary resource for beginners.
[http://www.roboter-forum.com/](http://www.roboter-forum.com/showthread.php?25097-Root-Zugriff-auf-Xiaomi-Mi-Vacuum-Robot)

Python-miio: Python library & console tool for controlling Xiaomi smart appliances. 
https://github.com/rytilahti/python-miio

Interesting Robotics class project "ROS on Xiaomi Robot" (by N. Dave, S. Pozder, J. Tan and P. Terrasi) advised by Prof. Hanumant Singh@NEU Field Robotics Lab: 
https://gitlab.com/EECE-5698-Group-7

# Communication for the community
Yes, there is a [telegram channel](https://t.me/joinchat/Fl7Mm0iEV7Pgf9ngDyly-g).

If you do not want to use telegram, you can use the [Matrix.to channel](https://matrix.to/#/#dustcloud:matrix.org)
or our IRC-Channel `#dustcloudproject` on [Freenode](https://freenode.net/), which is bridged to the matrix channel. 

In theory you can contact me via [twitter](https://twitter.com/dgi_DE).

I am communicating announcements over all channels. 

Please inform yourself in the forums and with the howtos before you post in this channel. Otherwise your message is very likely to be ignored.


# Contact
* Dennis Giese <dgiese[at]mit.edu> / [twitter](https://twitter.com/dgi_DE)
* Daniel Wegemer <daniel[at]wegemer.com>

# Press information
IoT will very likely become a very important topic in the future. 
If you like to know more about IoT security, you can visit me at Northeastern University in Boston, US. Please contact me.

# Acknowledgements:
### Prof. Matthias Hollick at Secure Mobile Networking Lab (SEEMOO)
<a href="https://www.seemoo.tu-darmstadt.de">![SEEMOO logo](https://github.com/dgiese/dustcloud-documentation/raw/master/gfx/seemoo.png)</a>
### Prof. Guevara Noubir (CCIS, Northeastern University)
<a href="http://www.ccs.neu.edu/home/noubir/Home.html">![CCIS logo](https://github.com/dgiese/dustcloud-documentation/raw/master/gfx/CCISLogo_S_gR.png)</a>
### Ilfak Guilfanov / Hex-Rays: for their great tool "IDA Pro"
<a href="https://www.hex-rays.com/">![Hex-rays logo](https://github.com/dgiese/dustcloud-documentation//raw/master/gfx/hex-rays.png)</a>
# Media coverage:
* https://www.golem.de/news/reverse-engineering-das-xiaomi-oekosystem-vom-hersteller-befreien-1802-132878.html
* https://www.kaspersky.com/blog/xiaomi-mi-robot-hacked/12567/
* https://www.golem.de/news/xiaomi-mit-einem-stueck-alufolie-autonome-staubsauger-rooten-1712-131883.html
* http://www.zeit.de/digital/datenschutz/2017-12/34c3-hack-staubsauger-iot
* https://hackaday.com/2017/12/27/34c3-the-first-day-is-a-doozy/
* https://m.heise.de/newsticker/meldung/34C3-Vernetzter-Staubsauger-Roboter-aus-China-gehackt-3928360.html
* https://www.notebookcheck.com/Security-Staubsauger-sammelt-neben-Staub-auch-Daten-ueber-die-Wohnung.275668.0.html
* https://derstandard.at/2000071134392/Sicherheitsforscher-hacken-Staubsaugerroboter-und-finden-Bedenkliches
