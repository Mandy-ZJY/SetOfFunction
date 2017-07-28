using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Web;

namespace DnsRmms.Services.Provider
{
    public class DownloadProvider : IHttpHandler
    {
        public DownloadProvider(string filePath, string mimeType==null)
        {
            if (string.IsNullOrEmpty(filePath))
                throw new ArgumentException("download fail , the path is empty");

            FilePath = filePath;
            mimeType = mimeType ?? "text/plain";
        }
        /// <summary>
        /// 绝对路径
        /// </summary>
        public string FilePath { get; set; }

        public string MimeType { get; set; }

        public void ProcessRequest(HttpContext context)
        {
            HttpResponse response = HttpContext.Current.Response;
            response.ClearContent();
            response.Clear();
            response.ContentType = MimeType;
            response.TransmitFile(FilePath);
            response.AddHeader("Content-Disposition", "attachment;filename=" + Path.GetFileName(FilePath) + ";");
            response.Flush();
            response.End();
        }

        public bool IsReusable
        {
            get { return false; }
        }

    }
}
