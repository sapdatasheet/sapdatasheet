;
; BIND data file for local loopback interface
;
$TTL	604800
@	IN	SOA	ns.sapdatasheet.com. root.ns.sapdatasheet.com. (
			      2		; Serial
			 604800		; Refresh
			  86400		; Retry
			2419200		; Expire
			 604800 )	; Negative Cache TTL
;
@	IN	NS    ns                           ; ns.sapdatasheet.com  is a nameserver for sapdatasheet.com
@	IN	NS    ns1                          ; ns1.sapdatasheet.com is a nameserver for sapdatasheet.com
@	IN	NS    ns2                          ; ns2.sapdatasheet.com is a nameserver for sapdatasheet.com
@	IN	A     166.63.125.80                ; IPv4 address for sapdatasheet.com
@	IN	AAAA  fe80::48d:bcff:fe00:762/64   ; IPv6 address for sapdatasheet.com
www IN  CNAME sapdatasheet.com.            ; www.sapdatasheet.com is an alias for sapdatasheet.com
ns	IN	A     166.63.125.80                ; IPv4 address for ns.sapdatasheet.com
ns1	IN	A     166.63.125.80                ; IPv4 address for ns1.sapdatasheet.com
ns2	IN	A     166.63.125.80                ; IPv4 address for ns2.sapdatasheet.com
www IN  A     166.63.125.80                ; IPv4 address for www.sapdatasheet.com
