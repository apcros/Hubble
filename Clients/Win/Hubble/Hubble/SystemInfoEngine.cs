using System;
using System.Diagnostics;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Hubble
{
    class SystemInfoEngine
    {
        private PerformanceCounter cpuCounter;
        public SystemInfoEngine()
        {
            cpuCounter = new PerformanceCounter("Processor", "% Processor Time", "_Total");
        }

        public string getTotalRam()
        {
            ulong ramTotal = new Microsoft.VisualBasic.Devices.ComputerInfo().TotalPhysicalMemory;
            ramTotal =  ramTotal / 1024 / 1024;
            return Convert.ToString(ramTotal);
        }

        public string getFreeRam()
        {
            ulong ramFree = new Microsoft.VisualBasic.Devices.ComputerInfo().AvailablePhysicalMemory;
            ramFree = ramFree / 1024 / 1024;
            return Convert.ToString(ramFree);

        }

        public string getCpuUsage()
        {
            
            return Convert.ToString(Math.Round(cpuCounter.NextValue()));
        }

        public string getName()
        {
            return Environment.MachineName; 
        }

        public string getOS()
        {
            return Convert.ToString(Environment.OSVersion);
        }
        public List<Drive> getDrivesInfo()
        {
        
            System.IO.DriveInfo[] drives = System.IO.DriveInfo.GetDrives();
            var list = new List<Drive>();

            foreach (System.IO.DriveInfo drive in drives)
            {
                if (drive.IsReady)
                {
                    list.Add(new Drive()
                    {
                        name = drive.Name,
                        free_space = Convert.ToString(drive.AvailableFreeSpace / 1024 / 1024),
                        total_space = Convert.ToString(drive.TotalSize / 1024 / 1024),
                        label = drive.VolumeLabel,
                        type = Convert.ToString(drive.DriveType),
                        format = drive.DriveFormat
                    });
                }
            }
            return list;
        }


    }

    class Drive
    {
        public string format;
        public string free_space;
        public string total_space;
        public string name;
        public string label;
        public string type;
    }
    
}
