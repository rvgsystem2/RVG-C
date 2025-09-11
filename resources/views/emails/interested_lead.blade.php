@php
    // Safe WhatsApp link build
    $raw = (string) ($lead->phone ?? '');
    $digits = preg_replace('/\D+/', '', $raw);
    if (strlen($digits) === 10) $digits = '91' . $digits; // assume India
    $waText = rawurlencode("Hi, I'm interested in {$package->name} (ID: {$package->id}).");
    $createdAt = optional($lead->created_at)->timezone('Asia/Kolkata')->format('d M Y, h:i A');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>New Interested Lead</title>
</head>
<body style="margin:0; padding:24px; background:#f6f9fc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;">
  <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td align="center">
        <table role="presentation" cellpadding="0" cellspacing="0" width="600" style="max-width:600px; background:#ffffff; border:1px solid #eaeef3; border-radius:12px; overflow:hidden;">
          <tr>
            <td style="padding:24px 24px 8px;">
              <h2 style="margin:0 0 6px; font-size:22px; color:#0f172a;">New Interested Lead</h2>
              <p style="margin:0; color:#475569;">You have a new enquiry for <strong>{{ $package->name ?? 'Package' }}</strong>.</p>
            </td>
          </tr>

          <tr>
            <td style="padding:16px 24px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                <tr>
                  <td style="padding:8px 0; color:#64748b; width:160px;">Package</td>
                  <td style="padding:8px 0; color:#0f172a;"><strong>{{ $package->name ?? '-' }}</strong> (ID: {{ $package->id ?? '-' }})</td>
                </tr>
                @if(!is_null($package->sale_price ?? null))
                  <tr>
                    <td style="padding:8px 0; color:#64748b;">Price</td>
                    <td style="padding:8px 0; color:#0f172a;">
                      ₹{{ number_format((float)($package->sale_price ?? 0), 2) }}
                      <span style="color:#94a3b8; text-decoration:line-through; margin-left:6px;">
                        ₹{{ number_format((float)($package->price ?? 0), 2) }}
                      </span>
                    </td>
                  </tr>
                @else
                  <tr>
                    <td style="padding:8px 0; color:#64748b;">Price</td>
                    <td style="padding:8px 0; color:#0f172a;">₹{{ number_format((float)($package->price ?? 0), 2) }}</td>
                  </tr>
                @endif
                <tr>
                  <td style="padding:8px 0; color:#64748b;">Lead Phone</td>
                  <td style="padding:8px 0; color:#0f172a;"><strong>{{ $lead->phone }}</strong></td>
                </tr>
                <tr>
                  <td style="padding:8px 0; color:#64748b;">Source</td>
                  <td style="padding:8px 0; color:#0f172a;">{{ $lead->source ?? 'package-details' }}</td>
                </tr>
                <tr>
                  <td style="padding:8px 0; color:#64748b;">Date / Time</td>
                  <td style="padding:8px 0; color:#0f172a;">{{ $createdAt ?? '-' }} IST</td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td style="padding:8px 24px 24px;">
              <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td align="left" style="padding-top:8px;">
                    <!-- Open Admin (replace with your actual route) -->
                    <a href="{{ url('/admin/interested-leads/'.$lead->id) }}"
                       style="display:inline-block; background:#2563eb; color:#ffffff; text-decoration:none; padding:10px 16px; border-radius:8px; font-weight:600;">
                      Open in Admin
                    </a>
                    <!-- Call & WhatsApp quick actions -->
                    <a href="tel:+{{ $digits }}" style="display:inline-block; margin-left:8px; background:#334155; color:#ffffff; text-decoration:none; padding:10px 16px; border-radius:8px; font-weight:600;">
                      Call Lead
                    </a>
                    @if($digits)
                    <a href="https://wa.me/{{ $digits }}?text={{ $waText }}" style="display:inline-block; margin-left:8px; background:#16a34a; color:#ffffff; text-decoration:none; padding:10px 16px; border-radius:8px; font-weight:600;">
                      WhatsApp Lead
                    </a>
                    @endif
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td style="padding:14px 24px; border-top:1px solid #eaeef3; color:#94a3b8; font-size:12px;">
              This notification was sent by {{ config('app.name') }}.
              @if(config('app.url')) <a href="{{ config('app.url') }}" style="color:#94a3b8; text-decoration:underline;">Visit site</a> @endif
            </td>
          </tr>
        </table>

        <div style="font-size:12px; color:#94a3b8; margin-top:12px;">
          If the buttons don’t work, call: +{{ $digits }} or WhatsApp: https://wa.me/{{ $digits }}
        </div>

      </td>
    </tr>
  </table>
</body>
</html>
