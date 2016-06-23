using System;
using System.Collections.Generic;
using System.Configuration;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;

namespace Hubble
{
    class Program
    {
        static void Main(string[] args)
        {
            ApiEngine ae = new ApiEngine();
            MenuCfg mc = new MenuCfg();
            
            if(mc.getCfg("device_id") == "" || mc.getCfg("apiEntry") == "")
            {
                mc.interactiveMenu();
            }

            Console.WriteLine("Edit config ? y/n [n]");
            if (Console.ReadLine() == "y") {
                mc.interactiveMenu();
            }
            
            Console.WriteLine("Hubble is starting...");
            while (true)
            {
                Console.Clear();
                string json_to_submit = ae.getJson();
                using (var client = new System.Net.WebClient())
                {
                    try
                    {
                        client.Headers[HttpRequestHeader.ContentType] = "application/json";
                        client.UploadData(mc.getCfg("apiEntry") + "api/v1/devices/" + mc.getCfg("device_id") + "/latest", System.Text.Encoding.UTF8.GetBytes(json_to_submit));
                    } catch (Exception e)
                    {
                        Console.WriteLine(e.StackTrace);
                    }
                    
                }
                if(mc.getCfg("verbose") == "yes")
                {
                    Console.WriteLine("Following JSON was sent for "+mc.getCfg("device_id")+"\n");
                    Console.WriteLine(json_to_submit);
                }
                
                System.Threading.Thread.Sleep(int.Parse(ConfigurationManager.AppSettings["refreshTime"]));
            }
        }
    }
}
