<table bgcolor="#f2f2f2" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;font:14px / 14px 'Proxima Nova', 'Calibri', 'Helvetica', Arial, sans-serif;">
  <tbody>
    <tr>
      <td style="border-collapse:collapse;">
        <table border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse:collapse;" align="center">
          <tbody>
            <tr>
              <td height="70">
                <h4 style="font-size: 20px;font-weight: 600;margin:0;padding: 30px 10px 30px 10px;text-align: center;"><?= Theme::get_bloginfo('name'); ?></h4>
              </td>
            </tr>
          </tbody>
        </table>

        <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse:collapse;" align="center">
          <tbody>
            <tr>
              <td width="30"></td>
              <td width="640" height="30"></td>
              <td width="30"></td>
            </tr>
            <tr>
              <td width="30"></td>
              <td width="640">
                <h2 style="margin:0;padding:0;font-size: 20px;"><?= $title; ?></h2>
              </td>
              <td width="30"></td>
            </tr>
            <tr>
              <td width="30"></td>
              <td width="640" height="25"></td>
              <td width="30"></td>
            </tr>
            <tr>
              <td width="30"></td>
              <td width="640" height="1" style="background:#f2f2f2;"></td>
              <td width="30"></td>
            </tr>
            <tr>
              <td width="30"></td>
              <td width="640" height="10"></td>
              <td width="30"></td>
            </tr>
            <tr>
              <td width="30"></td>
              <td width="640" style="font-size: 16px;">
                <?php if (isset($fullname) && $fullname): ?>
                  <p>Fullname: <?= $fullname; ?></p>
                <?php endif; ?>
                <?php if (isset($phone) && $phone): ?>
                  <p>Phone number: <?= $phone; ?></p>
                <?php endif; ?>
                <?php if (isset($email) && $email): ?>
                  <p>E-mail: <?= $email; ?></p>
                <?php endif; ?>
                <?php if (isset($subject) && $subject): ?>
                  <p>Subject: <?= $subject; ?></p>
                <?php endif; ?>
                <p>
                  Message:
                  <br><br>
                  <?= $message; ?>
                </p>
              </td>
              <td width="30"></td>
            </tr>
            <tr>
              <td width="30"></td>
              <td width="640" height="30"></td>
              <td width="30"></td>
            </tr>
          </tbody>
        </table>

        <table border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse:collapse;text-align:center;" align="center">
          <tbody>
            <tr>
              <td height="70">
                <p style="font-size:13px;color:#4c4c4c;">
                  All rights reserved.
                  <br>
                  © <?= date('Y') . ' ' . Theme::get_bloginfo('name') . ' ' . Theme::get_bloginfo('description'); ?>
                </p>
                <p style="font-size:13px;color:#4c4c4c;">
                  Created by <a href="https://www.ucoline.com/">www.ucoline.com</a>
                </p>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
