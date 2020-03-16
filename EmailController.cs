using System.Collections;
using UnityEngine.Networking;
using UnityEngine;

public class EmailController: MonoBehaviour
{
    public string email = "reciever@mail.com";
    public string screenShotURL = "https://www.your-domain.com/upload.php";

    void Start()
    {
       //sending email when start
        StartCoroutine(UploadPNG());
    }

    IEnumerator UploadPNG()
    {
        // We should only read the screen after all rendering is complete
        yield return new WaitForEndOfFrame();

        // Create a texture the size of the screen, RGB24 format
        int width = Screen.width;
        int height = Screen.height;
        var tex = new Texture2D(width, height, TextureFormat.RGB24, false);

        // Read screen contents into the texture
        tex.ReadPixels(new Rect(0, 0, width, height), 0, 0);
        tex.Apply();

        // Encode texture into PNG
        byte[] bytes = tex.EncodeToPNG();
        Destroy(tex);

        // Create a Web Form
        WWWForm form = new WWWForm();
        form.AddField("name", email);
        form.AddBinaryData("fileToUpload", bytes, "ScreenShot.png", "image/png");

        // Upload to a cgi script
        using (var w = UnityWebRequest.Post(screenShotURL, form))
        {
            yield return w.SendWebRequest();
            if (w.isNetworkError || w.isHttpError)
            {
                print(w.error);
            }
            else
            {
                print(w.uploadHandler);
            }
        }
    }
}