using System;
using System.Collections.Generic;
using System.Configuration;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Hubble
{
    class MenuCfg
    {

        public void interactiveMenu()
        {
            Console.Clear();
            Console.WriteLine("--- Configuration ---");
            Console.WriteLine("1) - Set the api domain [" + getCfg("apiEntry")+"]");
            Console.WriteLine("2) - Set the refresh rate  [" + getCfg("refreshTime") + "]");
            Console.WriteLine("3) - Is HubbleWeb Secure mode enabled ?  [" + getCfg("secureMode") + "]");
            Console.WriteLine("4) - API Token (Required if Secure mode is enabled) [" + getCfg("apiToken") + "]");
            Console.WriteLine("5) - Device id (Can be found on Hubble Interface) [" + getCfg("device_id") + "]");
            Console.WriteLine("6) - Verbose mode [" + getCfg("verbose") + "]");
            Console.WriteLine("x) - Exit");
            String r = Console.ReadLine();
            switch(r)
            {
                case "1":
                    Console.WriteLine("New value for api domain : ");
                    writeCfg("apiEntry",Console.ReadLine());
                break;

                case "2":
                    Console.WriteLine("New refresh time :");
                    writeCfg("refreshTime", Console.ReadLine());
                    break;

                case "3":
                    Console.WriteLine("Using secure mode ? yes/no");
                    writeCfg("secureMode", Console.ReadLine());
                    break;

                case "4":
                    Console.WriteLine("Your api Token : ");
                    writeCfg("apiToken", Console.ReadLine());
                    break;

                case "5":
                    Console.WriteLine("Enter your device id : ");
                    writeCfg("device_id", Console.ReadLine());
                    break;

                case "6":
                    Console.WriteLine("Activate verbose mode ? yes/no");
                    writeCfg("verbose", Console.ReadLine());
                    break;

                default: 
                    if(getCfg("device_id") == "" || getCfg("apiEntry") == "")
                    {
                        Console.Clear();
                        Console.WriteLine("Device ID or Api Entry missing, please fill theses to exit the menu");
                        Console.ReadLine();
                        this.interactiveMenu();
                    }
                    break;

            }
        }

        private void writeCfg(String key, String val)
        {


            Configuration cfmgr = ConfigurationManager.OpenExeConfiguration(ConfigurationUserLevel.None);
            KeyValueConfigurationCollection cc = cfmgr.AppSettings.Settings;
            cc[key].Value = val;
            cfmgr.Save(ConfigurationSaveMode.Modified);
            ConfigurationManager.RefreshSection("appSettings");
            this.interactiveMenu();
        }
        public string getCfg(String key)
        {
            return ConfigurationManager.AppSettings.Get(key);;
        }
    }

    
}
