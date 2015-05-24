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
@	IN	NS	ns.sapdatasheet.com.    ; ns.sapdatasheet.com  is a nameserver for sapdatasheet.com
@	IN	A	166.63.125.80           ; IPv4 address for sapdatasheet.com
@	IN	AAAA	::1                 ; IPv6 address
ns	IN	A	166.63.125.80           ; IPv4 address for ns.sapdatasheet.com
ns1	IN	A	166.63.125.80           ; IPv4 address for ns1.sapdatasheet.com
ns2	IN	A	166.63.125.80           ; IPv4 address for ns1.sapdatasheet.com
www	IN	A	166.63.125.80           ; IPv4 address for www.sapdatasheet.com
